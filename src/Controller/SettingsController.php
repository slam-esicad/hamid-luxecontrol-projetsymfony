<?php

namespace App\Controller;

use App\Entity\Brands;
use App\Form\BrandsType;
use App\Repository\BrandsRepository;
use App\Repository\UserRepository;
use Doctrine\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/app', 'app_')]
class SettingsController extends AbstractController
{
    #[Route('/reglages', name: 'settings')]
    public function index(UserRepository $repository, Request $request, EntityManagerInterface $entityManager, BrandsRepository $brandsRepository): Response
    {
        $brand = new Brands();
        $users = $repository->findAll();

        $brands = $brandsRepository->findBy([], [
            'name' => 'ASC'
        ], 15);

        $createBrandForm = $this->createForm(BrandsType::class, $brand);
        $createBrandForm->handleRequest($request);

        if($createBrandForm->isSubmitted() && $createBrandForm->isValid())
        {
            $entityManager->persist($brand);
            $entityManager->flush();

            return $this->redirectToRoute('app_settings');
        }

        return $this->render('dashboard/settings.html.twig', [
            'brands' => $brands,
            'createBrandForm' => $createBrandForm->createView(),
            'users' => $users
        ]);
    }

    #[Route('/reglages/marques', 'settings_brands')]
    public function brands(Request $request, BrandsRepository $brandsRepository): Response
    {
        $brand = new Brands();

        $brands = $brandsRepository->findBy([], [
            'name' => 'ASC'
        ]);

        $createBrandForm = $this->createForm(BrandsType::class, $brand);
        $createBrandForm->handleRequest($request);

        return $this->render('dashboard/brands.html.twig', [
            'brands' => $brands,
            'createBrandForm' => $createBrandForm->createView()
        ]);
    }

    #[Route('/reglages/marque/{id}', 'settings_edit_brand')]
    public function edit(EntityManagerInterface $entityManager, Brands $brands, Request $request): Response
    {
        $createBrandForm = $this->createForm(BrandsType::class, $brands);
        $createBrandForm->handleRequest($request);

        if($createBrandForm->isSubmitted() && $createBrandForm->isValid())
        {
            $entityManager->persist($brands);
            $entityManager->flush();

            return $this->redirectToRoute('app_settings');
        }

        return $this->render('dashboard/edit_brand.html.twig', [
            'createBrandForm' => $createBrandForm,
            'brand' => $brands
        ]);
    }


    #[Route('/reglages/marque/supprimer/{id}', 'settings_delete_brand')]
    public function delete(EntityManagerInterface $entityManager, Brands $brands)
    {

        $entityManager->remove($brands);
        $entityManager->flush();

        return $this->redirectToRoute('app_settings');
    }


}
