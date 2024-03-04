<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/app', 'app_')]
class SettingsUsersController extends AbstractController
{
    #[Route('/reglages/utilisateur/{id}', name: 'settings_users')]
    public function index(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Request $request, User $user): Response
    {
        $editUserForm = $this->createForm(UserType::class, $user);
        $editUserForm->handleRequest($request);

        if($editUserForm->isSubmitted() && $editUserForm->isValid())
        {

            if($editUserForm->get('password')->getData() !== null)
            {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $editUserForm->get('password')->getData()
                    )
                );
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_settings');
        }

        return $this->render('dashboard/edit_user.html.twig', [
            'editUserForm' => $editUserForm->createView(),
            'user' => $user
        ]);
    }

    #[Route('/reglages/utilisateurs/nouveau', 'settings_create_user')]
    public function create(EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();

        $createUserForm = $this->createForm(UserType::class, $user);
        $createUserForm->handleRequest($request);

        if($createUserForm->isSubmitted() && $createUserForm->isValid())
        {
            $user->setPassword($userPasswordHasher->hashPassword($user, $createUserForm->get('password')->getData()));

            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('dashboard/create_user.html.twig', [
            'createUserForm' => $createUserForm->createView()
        ]);
    }
}
