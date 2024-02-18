<?php

namespace App\Controller;

use App\Entity\Contracts;
use App\Form\ContractType;
use App\Repository\ContractsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function create(ContractsRepository $contractsRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $contract = new Contracts();

        $createContractForm = $this->createForm(ContractType::class, $contract);
        $createContractForm->handleRequest($request);

        if($createContractForm->isSubmitted() && $createContractForm->isValid())
        {

            $exists = $contractsRepository->findBy([
                'car' => $contract->getCar()->getId()
            ]);

            foreach ($exists as $exist)
            {
                if(($contract->getStartdate() >= $exist->getStartdate() && $contract->getEnddate() <= $exist->getEnddate()) || $contract->getEnddate() >= $exist->getStartdate())
                {
                    $this->addFlash('error', 'Une location est déjà en cours sur cette voiture sur le contrat n°' . $exist->getId() . ' (du ' . date_format($exist->getStartdate(), 'd/m/Y') . ' au ' . date_format($exist->getEnddate(), 'd/m/Y') . ')');
                    break;
                }
                else
                {
                    $contract->setPrice(0);
                    $contract->setStatus(0);

                    $entityManager->persist($contract);
                    $entityManager->flush();

                    return $this->redirectToRoute('app_contracts');

                }


            }



        }

        return $this->render('dashboard/create_contract.html.twig', [
            'createContractForm' => $createContractForm->createView()
        ]);
    }

    #[Route('/contrat/{id}', 'edit_contract')]
    public function edit(ContractsRepository $contractsRepository, Request $request, Contracts $contracts, EntityManagerInterface $entityManager): Response
    {

        $editContractForm = $this->createForm(ContractType::class, $contracts);
        $editContractForm->handleRequest($request);

        if($editContractForm->isSubmitted() && $editContractForm->isValid())
        {
            $exists = $contractsRepository->findBy([
                'car' => $contracts->getCar()->getId()
            ]);

            foreach ($exists as $exist)
            {
                if(($contracts->getStartdate() >= $exist->getStartdate() && $contracts->getEnddate() <= $exist->getEnddate()) || $contracts->getEnddate() >= $exist->getStartdate())
                {
                    $this->addFlash('error', 'Une location est déjà en cours sur cette voiture sur le contrat n°' . $exist->getId() . ' (du ' . date_format($exist->getStartdate(), 'd/m/Y') . ' au ' . date_format($exist->getEnddate(), 'd/m/Y') . ')');
                    break;
                }
                else
                {

                    $entityManager->persist($contracts);
                    $entityManager->flush();

                    return $this->redirectToRoute('app_contracts');

                }


            }
        }

        return $this->render('dashboard/edit_contract.html.twig', [
            'editContractForm' => $editContractForm,
            'contract' => $contracts
        ]);
    }

    #[Route('supprimer/{id}', 'delete_contract')]
    public function delete(EntityManagerInterface $entityManager, Contracts $contracts): Response
    {
        $entityManager->remove($contracts);
        $entityManager->flush();

        return $this->redirectToRoute('app_contracts');
    }
}
