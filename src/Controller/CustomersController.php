<?php

namespace App\Controller;

use App\Entity\ContactsCustomers;
use App\Entity\Customers;
use App\Form\CarType;
use App\Form\ContactType;
use App\Form\CustomerType;
use App\Repository\ContactsCustomersRepository;
use App\Repository\CustomersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Tests\Models\TypedProperties\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/app', name: 'app_')]
class CustomersController extends AbstractController
{
    #[Route('/clients', name: 'customers')]
    public function index(CustomersRepository $customersRepository): Response
    {

        $customers = $customersRepository->findAll();

        return $this->render('dashboard/customers.html.twig', [
            'customers' => $customers,
            'nb_customers' => count($customers)
        ]);
    }

    #[Route('/client/nouveau', 'create_customer')]
    public function create(Request $request, EntityManagerInterface $entityManager, CustomersRepository $customersRepository): Response
    {
        $customer = new Customers();

        $createCustomerForm = $this->createForm(CustomerType::class, $customer);
        $createCustomerForm->handleRequest($request); // ok

        if($createCustomerForm->isSubmitted() && $createCustomerForm->isValid())
        {
            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->redirectToRoute('app_customers');
        }

        return $this->render('dashboard/create_customer.html.twig', [
            'createCustomerForm' => $createCustomerForm
        ]);
    }

    #[Route('/client/{id}', 'edit_customer')]
    public function edit(int $id, EntityManagerInterface $entityManager, Request $request, Customers $customers, CustomersRepository $customersRepository): Response
    {
        $contact = new ContactsCustomers();

        $editCustomerForm = $this->createForm(CustomerType::class, $customers);
        $editCustomerForm->handleRequest($request);

        $addContactForm = $this->createForm(ContactType::class, $contact);
        $addContactForm->handleRequest($request);

        if($addContactForm->isSubmitted() && $addContactForm->isValid())
        {
            $contact->setCustomer($customers);
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('app_edit_customer', [
                'id' => $id
            ]);
        }

        if($editCustomerForm->isSubmitted() && $editCustomerForm->isValid())
        {
            $entityManager->persist($customers);
            $entityManager->flush();
            return $this->redirectToRoute('app_customers');
        }

        return $this->render('dashboard/edit_customer.html.twig', [
            'customer' => $customers,
            'editCustomerForm' => $editCustomerForm->createView(),
            'addContactForm' => $addContactForm->createView(),
            'contactsCustomers' => $customers->getContactsCustomers()
        ]);
    }

    #[Route('/voiture/supprimer/{id}', 'delete_customer')]
    public function delete(Customers $customers, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($customers);
        $entityManager->flush();

        return $this->redirectToRoute('app_cars');
    }
}