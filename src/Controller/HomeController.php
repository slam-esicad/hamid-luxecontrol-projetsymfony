<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(UsersRepository $UserRepository, Request $request): Response
    {
        $session = $request->getSession();

        if(empty($session->get('online'))) {
            if(isset($_POST['sub_login']))
            {
                $email = htmlspecialchars($_POST['email']);
                $password = sha1($_POST['password']);

                $user = $UserRepository->findOneBy(['email' => $email]);
                //var_dump($user->getPassword(), $password);
                if($user->getPassword() == $password) {
                    var_dump('ok');
                    $session->set('online', $email);
                    return $this->redirectToRoute('app_dashboard');
                }
            }
        } else {
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('home/index.html.twig');
    }
}
