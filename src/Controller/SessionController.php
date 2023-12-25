<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\CreateSessionFormType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(SessionRepository $sessionRepository): Response
    {

        $sessions = $sessionRepository->findBy([], ['title' => 'ASC']);
        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    #[Route('/session/create', name: 'create_session')]
    public function create(
        SessionRepository $sessionRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {

        $session = new Session();

        $form = $this->createForm(CreateSessionFormType::class, $session);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($session);
            $entityManager->flush();

            $this->addFlash('success', 'The session '.$session->getTitle().' was successfully added');
            return $this->redirectToRoute('create_session');
        }

        return $this->render('session/create.html.twig', [
            'createSessionForm' => $form->createView(),
        ]);
    }
}
