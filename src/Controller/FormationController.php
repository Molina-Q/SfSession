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
    #[Route('/formation', name: 'app_formation')]
    public function index(FormationRepository $formationRepository): Response
    {
        $formations = $formationRepository->findBy([], ['label' => 'ASC']);

        return $this->render('formation/index.html.twig', [
            'controller_name' => 'FormationController',
            'formations' => $formations
        ]);
    }

    #[Route('/formation/create', name: 'create_formation')]
    public function create(
        FormationRepository $formationRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {

        $form = $this->createForm(CreateFormationRequestFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $formation = new Formation;
            $formation->setLabel($form->get('label')->getData());

            $entityManager->persist($formation);
            $entityManager->flush();

            $this->addFlash('success', 'The formation '.$formation->getLabel().' was successfully added');

            return $this->redirectToRoute('create_formation');
        }

        $formations = $formationRepository->findBy([], ['label' => 'ASC']);

        return $this->render('formation/create.html.twig', [
            'createFormationForm' => $form->createView(),
        ]);
    }
}
