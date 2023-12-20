<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ResetPasswordRequestFormType;
use App\Form\ResetPasswordFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{

    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/forgot-password', name: 'forgot_password')]
    public function forgotPassword(
        Request $request, 
        UserRepository $userRepository, 
        TokenGeneratorInterface $tokenGeneratorInterface, 
        EntityManagerInterface $entityManager): Response 
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // user fait une request par email en cherchant le resultat de l'input email et en recupérant les données
            $user = $userRepository->findOneByEmail($form->get('email')->getData());

            //on verifie si le mail est relié a un user
            if($user) {
                // on génère un token de reinitialisation
                $token = $tokenGeneratorInterface->generateToken();
                $user->setResetToken($token);

                $entityManager->persist($user);
                $entityManager->flush();

                //on génère le lien pour reinitialiser
                $url = $this->generateUrl('reset_password', ['token' => $token], 
                UrlGeneratorInterface::ABSOLUTE_URL);

                // envoie le mail avec le lien générer au dessus
                $this->emailVerifier->sendEmail('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('no-reply@exemple.com', 'Mail Bot'))
                    ->to($user->getEmail())
                    ->subject('You forgot your password')
                    ->htmlTemplate('security/password_reset_email.html.twig'),
                    $url
                );

                $this->addFlash('success', 'Email sent correctly');
                return $this->redirectToRoute('app_login');

            }

            $this->addFlash('danger', 'there was a problem');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password_request.html.twig', [
            'requestPassForm' => $form->createView()
        ]);
    }     

    #[Route(path: '/forgot-password/{token}', name:'reset_password')]
    public function resetPassword(
        string $token,
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
        ): Response 
    {
        //on vérifie si on a ce token en bdd

        $user = $userRepository->findOneByResetToken($token);
        if($user) {
            $form = $this->createForm(ResetPasswordFormType::class);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $user->setResetToken("");

                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Password was successfully changed');
                return $this->redirectToRoute('app_login');
            }

            return $this->render('security/reset_password.html.twig', [
                'passForm' => $form->createView()
            ]);

        }

        $this->addFlash('danger', 'Token invalid');
        return $this->redirectToRoute("app_login");
    }
}
