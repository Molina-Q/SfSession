<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\CreateTagFormType;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{
    #[Route('/tag', name: 'app_tag')]
    public function index(TagRepository $tagRepository): Response
    {
        $tags = $tagRepository->findBy([], ['label' => 'ASC']);

        return $this->render('tag/index.html.twig', [
            'tags' => $tags,
        ]);
    }

    #[Route('/tag/create', name: 'create_tag')]
    public function create(
        TagRepository $tagRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {

        

        $form = $this->createForm(CreateTagFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $tag = new Tag;
            $tag->setLabel($form->get('label')->getData());

            $entityManager->persist($tag);
            $entityManager->flush();

            $this->addFlash('success', 'The tag '.$tag->getLabel().' was successfully added');
            return $this->redirectToRoute('create_tag');
        }

        return $this->render('tag/create.html.twig', [
            'createTagForm' => $form->createView(),
        ]);
    }
}
