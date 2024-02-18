<?php

namespace App\Controller;

use App\Repository\CarsRepository;
use App\Repository\ContractsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

#[Route('/app', name: 'app_')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(ContractsRepository $contractsRepository, CarsRepository $carsRepository): Response
    {
        $cars = $carsRepository->findAll();

        $ca = 0;

        $contracts = $contractsRepository->findBy([
            'status' => [0, 2]
        ]);

        foreach ($contracts as $c) {
            if($c->getStartdate() >= new DateTime(date('Y-m-d', strtotime('-1 year'))) && $c->getStartdate() <= new DateTime(date('Y-m-d')))
                $ca += $c->getPrice();
        }

        return $this->render('dashboard/dashboard.html.twig', [
            'nb_cars' => count($cars),
            'ca' => $ca
        ]);
    }
}
