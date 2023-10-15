<?php

namespace App\Controller;

use App\Entity\ContactsCustomers;
use App\Repository\ContactsCustomersRepository;
use App\Repository\CustomersRepository;
use Cassandra\Custom;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Tests\Extension\Validator\Constraints\Customer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactsController extends AbstractController
{
    #[Route('/contact-client/{id}', name: 'app_edit_contact_customer')]
    public function index(int $id, Request $request, CustomersRepository $customersRepository, EntityManagerInterface $entityManager, ContactsCustomersRepository $contactsCustomersRepository): Response
    {
        $contact = $contactsCustomersRepository->find($id);
        $customer = $customersRepository->find($contact->getCustomerId());


        if(isset($_POST['sub_edit_contact'])) {
            $firstname = htmlspecialchars($_POST['firstname']);
            $lastname = htmlspecialchars($_POST['lastname']);
            $function = htmlspecialchars($_POST['function']);
            $comment = htmlentities($_POST['comment']);

            if(!empty($firstname) || !empty($lastname)) {
                $contact->setFirstName($firstname);
                $contact->setLastName($lastname);
                $contact->setFunction($function);
                $contact->setComment($comment);

                $entityManager->flush();

                return $this->redirectToRoute('app_edit_customer', ['code' => $customer->getCode()]);

            }
        }

        return $this->render('dashboard/editcontactcustomer.html.twig', [
            'contact' => $contact
        ]);
    }


    #[Route('/supprimer-contact/{id}', name: 'app_contacts_delete')]
    public function delete(int $id, CustomersRepository $customersRepository, ContactsCustomersRepository $contactsCustomersRepository, EntityManagerInterface $entityManager): Response
    {

        $contact = $contactsCustomersRepository->find($id);
        $customer_id = $contact->getCustomerId();
        $customer_code = $customersRepository->find($customer_id)->getCode();

        $entityManager->remove($contact);
        $entityManager->flush();

        return $this->redirectToRoute('app_edit_customer', ['code' => $customer_code]);

    }


    #[Route('/ajouter-contact/{code}', name: 'app_add_contact')]
    public function add(string $code, CustomersRepository $customersRepository, EntityManagerInterface $entityManager) : Response {

        $customer = $customersRepository->findOneBy([
            'code' => $code
        ]);

        if(isset($_POST['sub_add_contact'])) {
            $firstname = htmlspecialchars($_POST['firstname']);
            $lastname = htmlspecialchars($_POST['lastname']);
            $function = htmlspecialchars($_POST['function']);
            $comment = htmlentities($_POST['comment']);

            if(!empty($firstname) || !empty($lastname)) {
                $contact = new ContactsCustomers();

                $contact->setCustomerId($customer->getId());
                $contact->setFirstName($firstname);
                $contact->setLastName($lastname);
                $contact->setFunction($function);
                $contact->setComment($comment);

                $entityManager->persist($contact);
                $entityManager->flush();

                return $this->redirectToRoute('app_edit_customer', ['code' => $customer->getCode()]);
            }
        }

        return $this->render('dashboard/add_contact_customer.html.twig', [
            'customer' => $customer
        ]);

    }
}
