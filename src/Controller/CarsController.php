<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Form\CarType;
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

        return $this->render('dashboard/cars.html.twig', [
            'cars_list' => $carsRepository->findAll()
        ]);
    }

    #[Route('/nouvelle-voiture', name: 'create_car')]
    public function create(SluggerInterface $slugger, EntityManagerInterface $entityManager, Request $request, CarsRepository $carsRepository) : Response
    {

        $car = new Cars();

        $createCarForm = $this->createForm(CarType::class, $car);
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

            return $this->redirectToRoute('app_cars');
        }

        return $this->render('dashboard/create_car.html.twig', [
            'createCarForm' => $createCarForm->createView()
        ]);
    }


    #[Route('/voiture/{id}', 'edit_car')]
    public function edit(SluggerInterface $slugger, Cars $cars, EntityManagerInterface $entityManager, Request $request, CarsRepository $carsRepository) : Response
    {

        $editCarForm = $this->createForm(CarType::class, $cars);
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

            return $this->redirectToRoute('app_cars');
        }

        return $this->render('dashboard/edit_car.html.twig', [
            'createCarForm' => $editCarForm->createView(),
            'car' => $cars
        ]);
    }

    #[Route('/voiture/supprimer/{id}', 'delete_car')]
    public function delete(EntityManagerInterface $entityManager, int $id, CarsRepository $carsRepository, Request $request) {

        $car = $carsRepository->find($id);

        $entityManager->remove($car);
        $entityManager->flush();

        return $this->redirectToRoute('app_cars');
    }
}
