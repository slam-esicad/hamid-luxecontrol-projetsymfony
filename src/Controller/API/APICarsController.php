<?php

namespace App\Controller\API;

use App\Entity\Cars;
use App\Repository\CarsRepository;
use App\Repository\ContractsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Validator\Constraints\DateTime;

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


    #[Route('car/{regNumber}')]
    public function show(string $regNumber, CarsRepository $carsRepository)
    {
        return $this->json($carsRepository->findOneBy(['reg_number' => $regNumber]), 200, [], [
            'groups' => ['cars.index']
        ]);
    }

    #[Route('car/{regNumber}/{startdate}/{enddate}')]
    public function isAvailable(CarsRepository $carsRepository, ContractsRepository $contractsRepository, string $regNumber, string $startdate, string $enddate)
    {
        $car = $carsRepository->findOneBy([
            'reg_number' => $regNumber
        ]);

        $exists = $contractsRepository->findBy([
            'car' => $car->getId()
        ]);

        if (count($exists) >= 1) {
            foreach ($exists as $exist) {

                if ((date($startdate) >= date_format($exist->getStartdate(), 'Y-m-d') && date($startdate) <= date_format($exist->getEnddate(), 'Y-m-d') || (date($enddate) >= date_format($exist->getStartdate(), 'Y-m-d')) && date($enddate) <= date_format($exist->getEnddate(), 'Y-m-d'))) {

                    $available = false;

                } else {
                    $available = true;
                }

                return $this->json(['available' => $available], 200, [], [

                ]);
            }

        }

    }
}