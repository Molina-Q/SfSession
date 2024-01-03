<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Module;
use App\Repository\TagRepository;
use App\Form\CreateModuleFormType;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    #[Route('/module', name: 'app_module')]
    public function index(ModuleRepository $moduleRepository, TagRepository $tagRepository): Response
    {
        return $this->redirectToRoute('app_tag');
    }

    #[Route('/module/create', name: 'create_module')]
    public function create(
        ModuleRepository $moduleRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {

        $module = new Module;

        $form = $this->createForm(CreateModuleFormType::class, $module, ['attr' => ['class' => 'form-create']]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
    
            $entityManager->persist($module);
            $entityManager->flush();

            $this->addFlash('success', 'The module '.$module->getLabel().' was successfully added');
            return $this->redirectToRoute('create_module');
        }

        return $this->render('module/create.html.twig', [
            'createModuleForm' => $form->createView(),
        ]);
    }

    #[Route('/module/update/{id}', name: 'update_module')]
    public function update(
        int $id,
        ModuleRepository $moduleRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {

        $module = $moduleRepository->findOneById($id);

        $form = $this->createForm(CreateModuleFormType::class, $module, ['attr' => ['class' => 'form-create']]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
    
            $entityManager->persist($module);
            $entityManager->flush();

            $this->addFlash('success', 'The module '.$module->getLabel().' was successfully updated');
            return $this->redirectToRoute('app_tag');
        }

        return $this->render('module/update.html.twig', [
            'updateModuleForm' => $form->createView(),
            'module' => $module

        ]);
    }

    #[Route('/module/delete/{id}', name: 'delete_module')]
    public function delete(
        int $id,
        ModuleRepository $moduleRepository,
        EntityManagerInterface $entityManager
    ): Response
    {

        $module = $moduleRepository->findOneById($id);

        $entityManager->remove($module);
        $entityManager->flush();

        $this->addFlash('success', 'The module '.$module->getLabel().' was successfully deleted');
        return $this->redirectToRoute('app_tag');
    }
}
