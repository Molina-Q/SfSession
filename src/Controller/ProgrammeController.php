<?php

namespace App\Controller;

use App\Form\CreateProgrammeFormType;
use App\Repository\ProgrammeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProgrammeController extends AbstractController
{
    #[Route('/programme', name: 'app_programme')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_session');
    }

    #[Route('/programme/update/{id}', name: 'update_programme')]
    public function update(
        int $id,
        ProgrammeRepository $programmeRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $programme = $programmeRepository->findOneById($id);

        $form = $this->createForm(CreateProgrammeFormType::class, $programme, ['attr' => ['class' => 'form-create']]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($programme);
            $entityManager->flush();

            $this->addFlash('success', 'The programme '.$programme->getModule()->getLabel().' was successfully updated');
            return $this->redirectToRoute('details_session', ['id' => $programme->getSession()->getId() ]);
        }

        return $this->render('programme/create.html.twig', [
            'createProgrammeForm' => $form->createView(),
            'programme' => $programme
        ]);
    }

    #[Route('/programme/delete/{id}', name: 'delete_programme')]
    public function delete(
        int $id,
        TagRepository $tagRepository,
        EntityManagerInterface $entityManager
    ): Response
    {

        $tag = $tagRepository->findOneById($id);

        $entityManager->remove($tag);
        $entityManager->flush();

        $this->addFlash('success', 'The tag '.$tag->getLabel().' was successfully deleted');
        return $this->redirectToRoute('app_tag');
    }
}
}
