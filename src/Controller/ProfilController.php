<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditNameFormType;
use App\Form\UserEditPasswordFormType;
use App\Security\UserAuthenticator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

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
        $form = $this->createForm(UserEditNameFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();

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
    public function profilEditPassword(Request $request, User $user, UserAuthenticator $authenticator,
        UserPasswordHasherInterface $hasher, UserAuthenticatorInterface $userAuthenticator,
        EntityManagerInterface $manager): Response
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

        return $this->render('pages/profil/profil_password.html.twig', compact('form'));
    }
}