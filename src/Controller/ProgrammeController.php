<?php

namespace App\Controller;

use App\Form\CreateProgrammeFormType;
use App\Repository\SessionRepository;
use App\Repository\ProgrammeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProgrammeController extends AbstractController
{
    #[Route('profile/programme', name: 'app_programme')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_session');
    }

    // #[Route('secretary/programme/update/{id}', name: 'update_programme')]
    // public function update(
    //     int $id,
    //     ProgrammeRepository $programmeRepository,
    //     Request $request,
    //     EntityManagerInterface $entityManager
    // ): Response
    // {
    //     $programme = $programmeRepository->findOneById($id);

    //     $form = $this->createForm(CreaterProgrammeFormType::class, $programme, ['attr' => ['class' => 'form-create']]);
    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid()) {

    //         $entityManager->persist($programme);
    //         $entityManager->flush();

    //         $this->addFlash('success', 'The programme '.$programme->getModule()->getLabel().' was successfully updated');
    //         return $this->redirectToRoute('details_session', ['id' => $programme->getSession()->getId() ]);
    //     }

    //     return $this->render('programme/create.html.twig', [
    //         'upgradeProgrammeForm' => $form->createView(),
    //         'programme' => $programme
    //     ]);
    // }

    #[Route('admin/programme/delete/{id}', name: 'delete_programme')]
    public function delete(
        int $id,
        ProgrammeRepository $programmeRepository,
        EntityManagerInterface $entityManager
    ): Response
    {

        $programme = $programmeRepository->findOneById($id);
        $session_id = $programme->getSession()->getId();

        $entityManager->remove($programme);
        $entityManager->flush();

        $this->addFlash('success', 'The module '.$programme->getModule()->getLabel().' was successfully deleted');
        return $this->redirectToRoute('details_session', ['id' => $session_id ]);
    }
}
