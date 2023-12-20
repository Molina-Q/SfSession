<?php

namespace App\Controller;

use App\Repository\FormationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(FormationRepository $formationRepository): Response
    {

        $formations = $formationRepository->findBy([], ['label' => 'ASC']);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'formations' => $formations
        ]);
    }
}
