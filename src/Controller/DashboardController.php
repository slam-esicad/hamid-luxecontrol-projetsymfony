<?php

namespace App\Controller;

use App\Repository\CarsRepository;
use App\Repository\ContractsRepository;
use App\Repository\CustomersRepository;
use Cassandra\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

#[Route('/app', name: 'app_')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(CustomersRepository $customersRepository, ContractsRepository $contractsRepository, CarsRepository $carsRepository): Response
    {
        $cars = $carsRepository->findAll();
        $customers = $customersRepository->findAll();

        $ca = 0;

        $contracts = $contractsRepository->findAll();
        $contracts_encours = $contractsRepository->findBy([
            'status' => 0
        ]);

        foreach ($contracts as $c) {
            if($c->getEnddate()->format('Y') == date('Y'))
                $ca += $c->getPrice();
        }

        return $this->render('dashboard/dashboard.html.twig', [
            'nb_cars' => count($cars),
            'nb_customers' => count($customers),
            'nb_contracts' => count($contracts_encours),
            'ca' => $ca
        ]);
    }
}
