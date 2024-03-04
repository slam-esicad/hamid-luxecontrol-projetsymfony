<?php

namespace App\Controller\API;

use App\Entity\Cars;
use App\Repository\CarsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/api/', 'api_')]
class APICarsController extends AbstractController
{
    #[Route('cars', 'cars')]
    public function index(CarsRepository $carsRepository)
    {
        return $this->json($carsRepository->findAll(), 200, [], [
            'groups' => ['cars.index']
        ]);
    }


    #[Route('car/{id}', requirements: ['id' => Requirement::DIGITS])]
    public function show(Cars $cars)
    {
        return $this->json($cars, 200, [], [
            'groups' => ['cars.index']
        ]);
    }
}