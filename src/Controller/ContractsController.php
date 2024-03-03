<?php

namespace App\Controller;

use App\Entity\Contracts;
use App\Form\ContractType;
use App\Repository\CarsRepository;
use App\Repository\ContractsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Clock\now;

#[Route('/app', 'app_')]
class ContractsController extends AbstractController
{
    #[Route('/contrats', name: 'contracts')]
    public function index(ContractsRepository $contractsRepository): Response
    {

        $contracts = $contractsRepository->findAll();

        $total_prices = 0;

        foreach ($contracts as $c) {
            if($c->getStatus() == 0) {
                $total_prices += $c->getPrice();
            }
        }

        return $this->render('dashboard/contracts.html.twig', [
            'nb_contracts' => count($contracts),
            'contracts' => $contracts,
            'total_prices' => $total_prices
        ]);
    }

    #[Route('/contrat/nouveau', 'create_contract')]
    public function create(CarsRepository $carsRepository, ContractsRepository $contractsRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $contract = new Contracts();

        $createContractForm = $this->createForm(ContractType::class, $contract);
        $createContractForm->handleRequest($request);

        if($createContractForm->isSubmitted() && $createContractForm->isValid())
        {

            $exists = $contractsRepository->findBy([
                'car' => $contract->getCar()->getId()
            ]);

            if(count($exists) >= 1)
            {
                foreach ($exists as $exist) {
                    if (($contract->getStartdate() >= $exist->getStartdate() && $contract->getStartdate() <= $exist->getEnddate()) || ($contract->getEnddate() >= $exist->getStartdate() && $contract->getEnddate() <= $exist->getEnddate())) {
                        $this->addFlash('error', 'Une location est déjà en cours sur cette voiture sur le contrat n°' . $exist->getId() . ' (du ' . date_format($exist->getStartdate(), 'd/m/Y') . ' au ' . date_format($exist->getEnddate(), 'd/m/Y') . ')');
                        break;
                    } else {
                        if($contract->getType() == 0) {
                            $car = $carsRepository->find($contract->getCar());
                            $car->setSelled(true);
                            $entityManager->persist($car);
                            $entityManager->flush();
                            $this->directAdd($contract, $entityManager); return $this->redirectToRoute('app_contracts');
                        }
                    }
                }
            }
            else {
                if($contract->getType() == 0) {
                    $car = $carsRepository->find($contract->getCar());
                    $car->setSelled(true);
                    $entityManager->persist($car);
                    $entityManager->flush();
                    $this->directAdd($contract, $entityManager); return $this->redirectToRoute('app_contracts');
                }
            }
        }

        return $this->render('dashboard/create_contract.html.twig', [
            'createContractForm' => $createContractForm->createView()
        ]);
    }

    public function directAdd($contract, $em, $price = null)
    {
        if ($price !== null)
        {
            $contract->setPrice($price);
        } else
        {
            $contract->setPrice(0);
            $contract->setStatus(0);
        }

        $em->persist($contract);
        $em->flush();
    }

    #[Route('/contrat/{id}', 'edit_contract')]
    public function edit(ContractsRepository $contractsRepository, Request $request, Contracts $contracts, EntityManagerInterface $entityManager): Response
    {

        $editContractForm = $this->createForm(ContractType::class, $contracts);
        $editContractForm->handleRequest($request);


        if($editContractForm->isSubmitted() && $editContractForm->isValid())
        {


            if($contracts->getType() == 1)
            {
                $exists = $contractsRepository->findBy([
                    'car' => $contracts->getCar()->getId()
                ]);



                if(count($exists) >= 1)
                {
                    $i = 0;
                    foreach ($exists as $exist) {

                        if (($contracts->getStartdate() >= $exist->getStartdate() && $contracts->getStartdate() <= $exist->getEnddate()) || ($contracts->getEnddate() >= $exist->getStartdate() && $contracts->getEnddate() <= $exist->getEnddate())) {

                            if($contracts->getId() == $exist->getId())
                            {
                                $i = 0;
                            } else {
                                $i++;
                            }

                        }
                    }

                    if($i == 0)
                    {
                        $this->directAdd($contracts, $entityManager, $contracts->getPrice());
                        return $this->redirectToRoute('app_contracts');
                    } else {
                        $this->addFlash('error', 'Une location est déjà en cours.');
                        return $this->redirectToRoute('app_contracts');
                    }


                }
            }


        }


        return $this->render('dashboard/edit_contract.html.twig', [
            'editContractForm' => $editContractForm,
            'contract' => $contracts
        ]);
    }

    #[Route('contrat/supprimer/{id}', 'delete_contract')]
    public function delete(EntityManagerInterface $entityManager, Contracts $contracts): Response
    {
        $entityManager->remove($contracts);
        $entityManager->flush();

        return $this->redirectToRoute('app_contracts');
    }




    #[Route('/contrats/magic/terminer-echeances', 'magic_finish_contracts')]
    public function magicFinishContracts(ContractsRepository $contractsRepository, EntityManagerInterface $entityManager): Response
    {
        $contracts = $contractsRepository->findBy([
            'status' => '0'
        ]);

        foreach ($contracts as $contract)
        {
            if($contract->getEnddate() < new DateTime())
            {
                $contract->setStatus(1);

                $entityManager->persist($contract);
                $entityManager->flush();
            }

        }

        return $this->redirectToRoute('app_contracts');
    }
}
