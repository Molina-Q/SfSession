<?php

namespace App\Controller;

use App\Entity\RegisterSession;
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

    #[Route('admin/register/session/create/{id}', name: 'create_register_session')]
    public function create(
        int $id,
        RegisterSessionRepository $registerSessionRepository,
        EntityManagerInterface $entityManager
    ): Response
    {

        $registerSession = new RegisterSession();
        
        $session_id = $registerSession->getSession()->getId();

        $registerSession->setSession();
        $registerSession->setStudent();
        

        $entityManager->persist($registerSession);
        $entityManager->flush();

        $this->addFlash('success', 'The user was successfully registered to the session');
        return $this->redirectToRoute('details_session', ['id' => $session_id ]);
    }

    #[Route('admin/register/session/delete/{id}', name: 'delete_register_session')]
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
