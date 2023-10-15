<?php

namespace App\Controller;

use App\Entity\Customers;
use App\Repository\ContactsCustomersRepository;
use App\Repository\CustomersRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Twig\Tests\html;

class CustomersController extends AbstractController
{
    #[Route('/clients', name: 'app_customers')]
    public function index(CustomersRepository $Customers): Response
    {
        $customers_list = $Customers->findAll();
        return $this->render('dashboard/customers.html.twig', [
            'customers_list' => $customers_list
        ]);
    }


    #[Route('/nouveau-client', name: 'app_new_customer')]
    public function new(EntityManagerInterface $entityManager, CustomersRepository $CustomersRep): Response
    {
        if(isset($_POST['sub_new_customer'])) {
            //$code = str_replace(' ', '', $_POST['name']) + 01;
            $name = htmlspecialchars($_POST['name']);
            $code_o = substr(str_replace(' ', '', $name), 0, 3);
            $search_code = $CustomersRep->findBy(['code' => $code_o . "01"]);
            $i = 1;

            foreach($search_code as $s) {
                $i++;
                $code = $code_o . str_pad($i, 2, '0', STR_PAD_LEFT);
            }

            $email = htmlspecialchars($_POST['email']);
            $phone = htmlspecialchars($_POST['phone']);
            $address = htmlspecialchars($_POST['address']);
            $pc = htmlspecialchars($_POST['pc']);
            $city = htmlspecialchars($_POST['city']);
            $website = htmlspecialchars($_POST['website']);
            $rib = htmlspecialchars($_POST['rib']);
            $comment = htmlspecialchars($_POST['comment']);
            if(!empty($_POST['pro'])) {
                $pro = htmlspecialchars($_POST['pro']);
            } else { $pro = null; }
            $siret = htmlspecialchars($_POST['siret']);
            $bic = htmlspecialchars($_POST['bic']);

            if(!empty($name)) {
                $customer = new Customers();

                $customer->setCode($code);
                $customer->setName($name);
                $customer->setEmail($email);
                $customer->setPhone($phone);
                $customer->setAddress($address);
                $customer->setPc($pc);
                $customer->setCity($city);
                $customer->setWebsite($website);
                $customer->setRib($rib);
                $customer->setComment($comment);
                $customer->setPro((bool)$pro);
                $customer->setSiret($pro ? $siret : null);
                $customer->setBic($pro ? $bic : null);

                $entityManager->persist($customer);
                $entityManager->flush();
            } else {
                echo "Il faut un nom";
            }
        }
        return $this->render('dashboard/newcustomer.html.twig');
    }


    #[Route('/client/{code}', name: 'app_edit_customer')]
    public function show(string $code, EntityManagerInterface $entityManager, Request $request, ContactsCustomersRepository $contactsCustomersRepository, CustomersRepository $customersRepository): Response
    {
        $customer = $customersRepository->findOneBy(['code' => $code]);
        if ($customer->getPro()) {
            $pro = true;
        } else {
            $pro = false;
        }

        if(isset($_POST['sub_edit_customer'])) {
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $phone = htmlspecialchars($_POST['phone']);
            $address = htmlspecialchars($_POST['address']);
            $pc = htmlspecialchars($_POST['pc']);
            $city = htmlspecialchars($_POST['city']);
            $website = htmlspecialchars($_POST['website']);
            $rib = htmlspecialchars($_POST['rib']);
            $comment = htmlspecialchars($_POST['comment']);
            if(!empty($_POST['pro'])) {
                $pro = htmlspecialchars($_POST['pro']);
            } else { $pro = null; }
            $siret = htmlspecialchars($_POST['siret']);
            $bic = htmlspecialchars($_POST['bic']);

            if(!empty($name)) {
                $customer_r = $entityManager->getRepository(Customers::class)->find(1);

                $customer_r->setName($name);
                $customer_r->setEmail($email);
                $customer_r->setPhone($phone);
                $customer_r->setAddress($address);
                $customer_r->setPc($pc);
                $customer_r->setCity($city);
                $customer_r->setWebsite($website);
                $customer_r->setRib($rib);
                $customer_r->setComment($comment);
                $customer_r->setPro((bool)$pro);
                $customer_r->setSiret($pro ? $siret : null);
                $customer_r->setBic($pro ? $bic : null);

                $entityManager->flush();
            } else {
                echo "vide";
            }
        }

        $contacts_customer = $contactsCustomersRepository->findBy([
            'customerId' => $customer->getId()
        ]);



        return $this->render('dashboard/infos_customer.html.twig', [
            'customer' => $customer,
            'pro' => $pro,
            'contacts_customer' => $contacts_customer
        ]);
    }

}