<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Entity\Maintenances;
use App\Form\MaintenanceType;
use App\Repository\CarsRepository;
use App\Repository\MaintenancesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('app', 'app_')]
class MaintenanceController extends AbstractController
{
    #[Route('/entretiens/{car}', name: 'maintenances')]
    public function index(Cars $car, MaintenancesRepository $maintenancesRepository): Response
    {
        $maintenances = $maintenancesRepository->findBy([
            'car' => $car
        ]);

        return $this->render('dashboard/maintenances.html.twig', [
            'car' => $car,
            'maintenances' => $maintenances
        ]);
    }


    #[Route('/entretiens/{id}/nouveau', 'create_maintenance')]
    public function create(MaintenancesRepository $maintenancesRepository, Request $request, Cars $car, EntityManagerInterface $entityManager): Response
    {
        $maintenance = new Maintenances();

        $maintenanceForm = $this->createForm(MaintenanceType::class, $maintenance);
        $maintenanceForm->handleRequest($request);

        if($maintenanceForm->isSubmitted() && $maintenanceForm->isValid())
        {

            $existMaintenances = $maintenancesRepository->findBy([
                'car' => $car->getId()
            ]);

            $maintenance->setCar($car);

            foreach($existMaintenances as $exist)
            {
                if($exist->getDate() == $maintenance->getDate())
                {
                    if($exist->getHour() == $maintenance->getHour()) {
                        $this->addFlash('error', 'Vous ne pouvez pas ajouter un entretien en même temps qu\'un autre');

                        return $this->redirectToRoute('app_maintenances', [
                            'car' => $car->getId()
                        ]);
                    }
                }
            }

            $entityManager->persist($maintenance);
            $entityManager->flush();

            $this->addFlash('success', "L'entretien à bien été ajouté pour cette voiture");

            return $this->redirectToRoute('app_maintenances', [
                'car' => $car->getId()
            ]);
        }

        return $this->render('dashboard/create_maintenance.html.twig', [
            'car' => $car,
            'maintenanceForm' => $maintenanceForm->createView()
        ]);
    }

    #[Route('/entretiens/voir/{id}', 'show_maintenance')]
    public function show(Maintenances $maintenances, CarsRepository $carsRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $car = $carsRepository->find($maintenances->getCar());

        $maintenanceForm = $this->createForm(MaintenanceType::class, $maintenances);
        $maintenanceForm->handleRequest($request);

        if($maintenanceForm->isSubmitted() && $maintenanceForm->isValid())
        {
            $entityManager->persist($maintenances);
            $entityManager->flush();

            $this->addFlash('success', "L'entretien à bien été modifié pour cette voiture");

            return $this->redirectToRoute('app_maintenances', [
                'car' => $car->getId()
            ]);
        }

        return $this->render('dashboard/maintenance.html.twig', [
            'mainteannce' => $maintenances,
            'car' => $car,
            'maintenanceForm' => $maintenanceForm->createView()
        ]);
    }


    #[Route('/entretiens/{id}/supprimer', name: 'maintenance_delete')]
    public function delete(CarsRepository $carsRepository, Maintenances $maintenances, EntityManagerInterface $entityManager): Response
    {
        $car = $carsRepository->find($maintenances->getCar());

        $entityManager->remove($maintenances);
        $entityManager->flush();

        $this->addFlash('success', "L'entretien à bien été supprimé pour cette voiture");

        return $this->redirectToRoute('app_maintenances', [
            'car' => $car->getId()
        ]);
    }
}