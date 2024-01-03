<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UpdateUserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findBy([], ["last_name" => "ASC"]);
        
        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/user/{id}', name: 'details_user')]
    public function details(User $user): Response
    {
        return $this->render('user/details.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/update/{id}', name: 'update_user')]
    public function update(
        int $id,
        UserRepository $userRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $user = $userRepository->findOneById($id);

        $form = $this->createForm(UpdateUserFormType::class, $user, ['attr' => ['class' => 'form-create']]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Your informations were successfully updated');
            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/update.html.twig', [
            'updateUserForm' => $form->createView(),
            'user' => $user
        ]);
    }

    #[Route('/user/delete/{id}', name: 'delete_user')]
    public function delete(
        int $id,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response
    {

        $user = $userRepository->findOneById($id);

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'The user '.$user->getLabel().' was successfully deleted');
        return $this->redirectToRoute('app_user');
    }
}
