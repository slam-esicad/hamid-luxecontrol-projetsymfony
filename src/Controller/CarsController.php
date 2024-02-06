<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Form\CreateCarType;
use App\Repository\CarsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('app', 'app_')]
class CarsController extends AbstractController
{
    #[Route('/voitures', name: 'cars')]
    public function index(CarsRepository $carsRepository): Response
    {

        $cars_list = $carsRepository->findAll();

        return $this->render('dashboard/cars.html.twig', [
            'cars_list' => $cars_list,
            'nb_cars' => count($cars_list)
        ]);
    }

    #[Route('/nouvelle-voiture', name: 'create_car')]
    public function create(SluggerInterface $slugger, EntityManagerInterface $entityManager, Request $request, CarsRepository $carsRepository) : Response
    {

        $car = new Cars();

        $createCarForm = $this->createForm(CreateCarType::class, $car);
        $createCarForm->handleRequest($request);


        if($createCarForm->isSubmitted() && $createCarForm->isValid())
        {
            if($createCarForm->get('img') !== null) {

                $file = $createCarForm->get('img')->getData();

                if($file)
                {
                    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                    $file->move('uploads',  $newFilename);
                    $car->setImg($newFilename);
                }

            }
            $entityManager->persist($car);
            $entityManager->flush();
        }

        return $this->render('dashboard/create_car.html.twig', [
            'createCarForm' => $createCarForm->createView()
        ]);
    }


    #[Route('/voiture/{id}', 'edit_car')]
    public function edit(SluggerInterface $slugger, Cars $cars, EntityManagerInterface $entityManager, Request $request, CarsRepository $carsRepository) : Response
    {

        $editCarForm = $this->createForm(CreateCarType::class, $cars);
        $editCarForm->handleRequest($request);

        if($editCarForm->isSubmitted() && $editCarForm->isValid())
        {
            if($editCarForm->get('img') !== null) {

                $file = $editCarForm->get('img')->getData();

                if($file)
                {
                    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                    $file->move('uploads',  $newFilename);
                    $cars->setImg($newFilename);
                }

            }

            $entityManager->persist($cars);
            $entityManager->flush();
        }

        return $this->render('dashboard/edit_car.html.twig', [
            'createCarForm' => $editCarForm->createView(),
            'car' => $cars
        ]);
    }
}
