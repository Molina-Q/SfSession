<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Programme;
use App\Form\CreateSessionFormType;
use App\Form\UpdateSessionFormType;
use App\Form\CreateProgrammeFormType;
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
    
    #[Route('/session/{id}', name: 'details_session')]
    public function details(
        int $id,
        SessionRepository $sessionRepository,
        EntityManagerInterface $entityManager,
        Request $request,
        ): Response
    {

        $programme = new Programme();

        $form = $this->createForm(CreateProgrammeFormType::class, $programme);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($programme);
            $entityManager->flush();

            // $this->addFlash('success', 'The programme '.$programme->getLabel().' was successfully added');
            return $this->redirectToRoute('details_session', ['id' => $id]);
        }
        

        $session = $sessionRepository->findOneById($id);

        return $this->render('session/details.html.twig', [
            'addProgrammeForm' => $form->createView(),
            'session' => $session,
        ]);
    }


    
    #[Route('/session/update/{id}', name: 'update_session')]
    public function update(
        SessionRepository $sessionRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        int $id,
    ): Response
    {

        $session = $sessionRepository->findOneById($id);

        $form = $this->createForm(UpdateSessionFormType::class, $session);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($session);
            $entityManager->flush();

            $this->addFlash('success', 'The session '.$session->getTitle().' was successfully updated');
            return $this->redirectToRoute('app_session');
        }

        return $this->render('session/update.html.twig', [
            'updateSessionForm' => $form->createView(),
        ]);
    }
}
