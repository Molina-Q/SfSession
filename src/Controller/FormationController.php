<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CreateFormationRequestFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    /* list of formation */
    #[Route('profile/formation', name: 'app_formation')]
    public function index(FormationRepository $formationRepository): Response
    {
        $formations = $formationRepository->findBy([], ['label' => 'ASC']);

        return $this->render('formation/index.html.twig', [
            'controller_name' => 'FormationController',
            'formations' => $formations
        ]);
    }

    /* list of formation */
    #[Route('secretary/formation/create', name: 'create_formation')]
    public function create(
        FormationRepository $formationRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $formation = new Formation();

        $form = $this->createForm(CreateFormationRequestFormType::class, $formation, ['attr' => ['class' => 'form-create']]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($formation);
            $entityManager->flush();

            $this->addFlash('success', 'The formation '.$formation->getLabel().' was successfully added');

            return $this->redirectToRoute('create_formation');
        }

        return $this->render('formation/create.html.twig', [
            'createFormationForm' => $form->createView(),
        ]);
    }

    #[Route('secretary/formation/update/{id}', name: 'update_formation')]
    public function update(
        int $id,
        FormationRepository $formationRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $formation = $formationRepository->findOneById($id);

        $form = $this->createForm(CreateFormationRequestFormType::class, $formation, ['attr' => ['class' => 'form-create']]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($formation);
            $entityManager->flush();

            $this->addFlash('success', 'The formation '.$formation->getLabel().' was successfully updated');

            return $this->redirectToRoute('app_formation');
        }

        return $this->render('formation/update.html.twig', [
            'updateFormationForm' => $form->createView(),
            'formation' => $formation,
        ]);
    }

    #[Route('admin/formation/delete/{id}', name: 'delete_formation')]
    public function delete(
        int $id,
        FormationRepository $formationRepository,
        EntityManagerInterface $entityManager
    ): Response
    {

        $formation = $formationRepository->findOneById($id);

        $entityManager->remove($formation);
        $entityManager->flush();

        $this->addFlash('success', 'The formation '.$formation->getLabel().' was successfully deleted');
        return $this->redirectToRoute('app_tag');
    }
}
