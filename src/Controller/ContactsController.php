<?php

namespace App\Controller;

use App\Entity\ContactsCustomers;
use App\Form\ContactType;
use App\Repository\ContactsCustomersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/app', name: 'app_')]
class ContactsController extends AbstractController
{
    #[Route('/contact/{id}', name: 'edit_contact')]
    public function edit(EntityManagerInterface $entityManager, Request $request, ContactsCustomers $contactsCustomers): Response
    {

        $editContactForm = $this->createForm(ContactType::class, $contactsCustomers);
        $editContactForm->handleRequest($request);

        if($editContactForm->isSubmitted() && $editContactForm->isValid())
        {
            $entityManager->persist($contactsCustomers);
            $entityManager->flush();

            return $this->redirectToRoute('app_edit_customer', [
                'id' => $contactsCustomers->getCustomer()->getId()
            ]);
        }

        return $this->render('dashboard/edit_contact.html.twig', [
            'contact' => $contactsCustomers,
            'editContactForm' => $editContactForm->createView()
        ]);
    }

    #[Route('/contact/supprimer/{id}', 'delete_contact')]
    public function delete(int $id, ContactsCustomersRepository $contactsCustomersRepository, ContactsCustomers $contactsCustomers, EntityManagerInterface $entityManager): Response
    {

        if($contactsCustomersRepository->find($id))
        {
            $entityManager->remove($contactsCustomers);
            $entityManager->flush();
        } else
        {
            return $this->redirectToRoute('app_edit_customer', [
                'id' => $contactsCustomers->getCustomer()->getId()
            ]);
        }

        return $this->redirectToRoute('app_edit_customer', [
            'id' => $contactsCustomers->getCustomer()->getId()
        ]);
    }
}
