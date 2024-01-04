<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Programme;
use App\Entity\RegisterSession;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use App\Form\CreateSessionFormType;
use App\Form\UpdateSessionFormType;
use App\Form\CreateProgrammeFormType;
use App\Repository\SessionRepository;
use App\Form\RegisterToSessionFormType;
use App\Repository\FormationRepository;
use App\Repository\ProgrammeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('profile/session', name: 'app_session')]
    public function index(SessionRepository $sessionRepository): Response
    {

        $sessions = $sessionRepository->findBy([], ['dateStart' => 'DESC']);
        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    #[Route('secretary/session/create', name: 'create_session')]
    public function create(
        SessionRepository $sessionRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {

        $session = new Session();

        $form = $this->createForm(CreateSessionFormType::class, $session, ['attr' => ['class' => 'form-create']]);
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
    
    #[Route('profile/session/{id}', name: 'details_session')]
    public function details(
        int $id,
        SessionRepository $sessionRepository,
        TagRepository $tagRepository,
        ProgrammeRepository $programmeRepository,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        Request $request,
        ): Response
    {

        $session = $sessionRepository->findOneById($id);
        

        $programme = new Programme();

        $formProgramme = $this->createForm(CreateProgrammeFormType::class, $programme, ['attr' => ['class' => 'form-create']]);
        $formProgramme->handleRequest($request);

        if($formProgramme->isSubmitted() && $formProgramme->isValid()) {

            $programme->setSession($session);

            $entityManager->persist($programme);
            $entityManager->flush();

            // $this->addFlash('success', 'The programme '.$programme->getLabel().' was successfully added');
            return $this->redirectToRoute('details_session', ['id' => $id]);
        }

        $registerSession = new RegisterSession();

        $formStudent = $this->createForm(RegisterToSessionFormType::class, $registerSession, ['attr' => ['class' => 'form-create']]);
        $formStudent->handleRequest($request);

        if($formStudent->isSubmitted() && $formStudent->isValid()) {

            $registerSession->setSession($session);

            $entityManager->persist($registerSession);
            $entityManager->flush();

            // $this->addFlash('success', 'The programme '.$programme->getLabel().' was successfully added');
            return $this->redirectToRoute('details_session', ['id' => $id]);
        }

        $tags = $programmeRepository->findProgrammesByTags($id);

        $unregisteredUser = $userRepository->findUnregisteredUser($id);
        
        $registeredUser = $userRepository->findRegisteredUser($id);

        return $this->render('session/details.html.twig', [
            'addProgrammeForm' => $formProgramme->createView(),
            'addStudentForm' => $formStudent->createView(),
            'session' => $session,
            'tags' => $tags,
            'unregisteredUser' => $unregisteredUser,
            'registeredUser' => $registeredUser,
        ]);
    }

    #[Route('profile/session/formation/{id}', name: 'list_session')]
    public function listByFormation(
        int $id,
        SessionRepository $sessionRepository,
        FormationRepository $formationRepository,
        EntityManagerInterface $entityManager,
        Request $request,
        ): Response
    {

        // $sessions = $sessionRepository->findByFormation($id);
        $formation = $formationRepository->findOneById($id);

        return $this->render('session/listByFormation.html.twig', [
            // 'sessions' => $sessions,
            'formation' => $formation,
        ]);
    }

    #[Route('secretary/session/update/{id}', name: 'update_session')]
    public function update(
        SessionRepository $sessionRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        int $id,
    ): Response
    {

        $session = $sessionRepository->findOneById($id);

        $form = $this->createForm(CreateSessionFormType::class, $session, ['attr' => ['class' => 'form-create']]);
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

    #[Route('admin/session/delete/{id}', name: 'delete_session')]
    public function delete(
        int $id,
        SessionRepository $sessionRepository,
        EntityManagerInterface $entityManager
    ): Response
    {

        $session = $sessionRepository->findOneById($id);

        $entityManager->remove($session);
        $entityManager->flush();

        $this->addFlash('success', 'The session '.$session->getLabel().' was successfully deleted');
        return $this->redirectToRoute('app_tag');
    }
}
