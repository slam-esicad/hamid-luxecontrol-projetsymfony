<?php

namespace App\Controller;

use App\Entity\Customers;
use App\Repository\CustomersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(CustomersRepository $customersRepository, Request $request): Response
    {
        $session = $request->getSession();

        $count_customers = count($customersRepository->findAll());

        if($session->get('online')) {
            return $this->render('dashboard/dashboard.html.twig', [
                'count_customers' => $count_customers
            ]);
        } else {
            return $this->redirectToRoute('app_home');
        }
    }
}
