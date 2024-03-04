<?php

namespace App\Controller;

use App\Form\DateStatisticsType;
use App\Form\SearchType;
use App\Repository\CarsRepository;
use App\Repository\ContractsRepository;
use App\Repository\CustomersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

#[Route('/app', name: 'app_')]
class StatisticsController extends AbstractController
{
    #[Route('/statistiques', name: 'statistics')]
    public function index(ChartBuilderInterface $chartBuilder, CustomersRepository $customersRepository, Request $request, CarsRepository $carsRepository, ContractsRepository $contractsRepository): Response
    {
        $contracts = $contractsRepository->findAll();

        $periodForm = $this->createForm(DateStatisticsType::class);
        $periodForm->handleRequest($request);

        $top10ContractsRented = $contractsRepository->find10BestRentedCars();

        if($request->get('tri_by_nb_loca') !== null) {
            $top10ContractsRented = $contractsRepository->find10BestCars();
        }

        $customers = [];
        if($request->get('search1') !== null)
        {
            $customers = $customersRepository->getCaOfClientFromWord('name', $request->get('search1'));
        }

        $cars = [];
        if($request->get('search2') !== null)
        {
            $cars = $carsRepository->getCarInfoWithContractPricesAndBrand($request->get('search2'));
        }

        $renteds = $contractsRepository->findBy([
            'type' => 1
        ]);

        $year = date('Y');
        if($periodForm->isSubmitted() && $periodForm->isValid())
        {
            $year = $periodForm->get('year')->getData();

        }

        $caOfYear = 0;
        foreach ($contracts as $contract) {
            if($contract->getEnddate()->format('Y') == $year)
            {
                $caOfYear += $contract->getPrice();
            }
        }

        $locByMonth = [];
        $totalPricesByMonth = [];
        foreach ($renteds as $rented)
        {
            if($rented->getEnddate()->format('Y') == $year)
            {
                $endDate = $rented->getEnddate();

                $month = $endDate->format('F');
                switch ($month) {
                    case "January": $month = 'Janvier'; break;
                    case "February": $month = 'Février'; break;
                    case "March": $month = 'Mars'; break;
                    case "April": $month = 'Avril'; break;
                    case "May": $month = 'Mai'; break;
                    case "June": $month = 'Juin'; break;
                    case "July": $month = 'Juillet'; break;
                    case "August": $month = 'Août'; break;
                    case "September": $month = 'Septembre'; break;
                    case "October": $month = 'Octobre'; break;
                    case "November": $month = 'Novembre'; break;
                    case "December": $month = 'Décembre'; break;
                }

                $price = $rented->getPrice();

                $locByMonth[] = [
                    'month' => $month,
                    'price' => $price
                ];

                if (!isset($totalPricesByMonth[$month])) {
                    $totalPricesByMonth[$month] = 0;
                }

                $totalPricesByMonth[$month] += $price;
            }
        }

        $caVentes = 0;
        $caLocations = 0;
        foreach($contracts as $contract)
        {
            if($contract->getEnddate()->format('Y') == $year)
            {
                if($contract->getType() == 1)
                {
                    $caVentes += $contract->getPrice();
                } else if ($contract->getType() == 0)
                {
                    $caLocations += $contract->getPrice();

                }
            }
        }

        $CAGlobal[] = [$caVentes, $caLocations];

        return $this->render('dashboard/statistics.html.twig', [
            'periodForm' => $periodForm->createView(),
            'top10ContractsRented' => $top10ContractsRented,
            'customers' => $customers,
            'cars' => $cars,
            'totalPricesByMonth' => json_encode($totalPricesByMonth),
            'year' => $year,
            'CAGlobal' => json_encode($CAGlobal[0]),
            'caOfYear' => $caOfYear
        ]);
    }
}
