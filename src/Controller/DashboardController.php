<?php

namespace App\Controller;

use App\Repository\CarsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/app', name: 'app_')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(CarsRepository $carsRepository): Response
    {
        $cars = $carsRepository->findAll();
        return $this->render('dashboard/dashboard.html.twig', [
            'nb_cars' => count($cars)
        ]);
    }
}
