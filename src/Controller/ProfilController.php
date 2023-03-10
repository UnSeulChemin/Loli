<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditNameFormType;
use App\Security\UserAuthenticator;
use App\Form\UserEditPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil', methods: ['GET', 'POST'])]
    public function profil(): Response
    {
        return $this->render('pages/profil/profil.html.twig');
    }

    #[Route('/profil/edit/name/{id}', name: 'app_profil_edit_name', methods: ['GET', 'POST'])]
    public function profilEditName(Request $request, User $user, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserEditNameFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('pages/profil/profil_edit_name.html.twig', compact('form'));
    }

    #[Route('/profil/edit/password/{id}', name: 'app_profil_edit_password', methods: ['GET', 'POST'])]
    public function profilEditPassword(Request $request, User $user, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator): Response
    {
        $form = $this->createForm(UserEditPasswordFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // encode the plain password
            $user->setPassword(
                $hasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $manager->persist($user);
            $manager->flush();

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('pages/profil/profil_edit_password.html.twig', compact('form'));
    }
}
