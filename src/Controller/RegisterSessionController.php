<?php

namespace App\Controller;

use App\Entity\RegisterSession;
use App\Repository\UserRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RegisterSessionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegisterSessionController extends AbstractController
{
    #[Route('profile/register/session', name: 'app_register_session')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_session');
    }

    #[Route('secretary/register-session/create/{id_se}/{id_us}', name: 'create_register_session')]
    public function create(
        int $id_se,
        int $id_us,
        UserRepository $userRepository,
        SessionRepository $sessionRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $session = $sessionRepository->findOneById($id_se);
        if($session->slotFree() <= 0) {
            $this->addFlash('error', 'The session is full you cannot add more students');
            return $this->redirectToRoute('details_session', ['id' => $id_se ]);
        }

        $user = $userRepository->findOneById($id_us);

        $registerSession = new RegisterSession();
        
        $registerSession->setSession($session);
        $registerSession->setStudent($user);
        
        $entityManager->persist($registerSession);
        $entityManager->flush();

        $this->addFlash('success', 'The user was successfully registered to the session');
        return $this->redirectToRoute('details_session', ['id' => $id_se ]);
    }

    #[Route('secretary/register-session/delete/{id}', name: 'delete_register_session')]
    public function delete(
        int $id,
        RegisterSessionRepository $registerSessionRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $registerSession = $registerSessionRepository->findOneById($id);
        $session_id = $registerSession->getSession()->getId();
    
        $entityManager->remove($registerSession);
        $entityManager->flush();

        $this->addFlash('success', 'The user was successfully unregistered');
        return $this->redirectToRoute('details_session', ['id' => $session_id ]);
    }
}
