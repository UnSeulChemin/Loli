<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserNameFormType;
use App\Form\UserPasswordFormType;
use App\Security\UserAuthenticator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

/**
 * Page Profil
 */
class ProfilController extends AbstractController
{
    /**
     * Page Profil
     *
     * @return Response
     */
    #[Route('/profil', name: 'app_profil', methods: ['GET', 'POST'])]
    public function profil(): Response
    {
        return $this->render('pages/profil/profil.html.twig');
    }

    /**
     * * Page Profil, Edit Name
     *
     * @param Request $request
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/profil/name/{id}', name: 'app_profil_name', methods: ['GET', 'POST'])]
    public function profilName(Request $request, User $user, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserNameFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Your name have been successfully edited !');
            return $this->redirectToRoute('app_profil');
        }

        return $this->render('pages/profil/profil_name.html.twig', compact('form'));
    }

    /**
     * * Page Profil, Edit Password
     *
     * @param Request $request
     * @param User $user
     * @param UserAuthenticator $authenticator
     * @param UserPasswordHasherInterface $hasher
     * @param UserAuthenticatorInterface $userAuthenticator
     * @param EntityManagerInterface $manager
     * @return Response
     */    
    #[Route('/profil/password/{id}', name: 'app_profil_password', methods: ['GET', 'POST'])]
    public function profilPassword(Request $request, User $user, UserAuthenticator $authenticator,
        UserPasswordHasherInterface $hasher, UserAuthenticatorInterface $userAuthenticator,
        EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserPasswordFormType::class, $user);
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

            $this->addFlash('success', 'Your password have been successfully edited !');
            return $this->redirectToRoute('app_profil');
        }

        else if ($form->isSubmitted() && !$form->isValid())
        {
            $this->addFlash('warning', 'Complete the following step and try again.');
        }

        return $this->render('pages/profil/profil_password.html.twig', compact('form'));
    }
}