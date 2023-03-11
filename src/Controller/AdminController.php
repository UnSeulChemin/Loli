<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Contact;

use App\Repository\UserRepository;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Page Admin
 */
class AdminController extends AbstractController
{
    /**
     * Page Admin
     *
     * @return Response
     */
    #[Route('/admin', name: 'app_admin')]
    public function admin(): Response
    {
        return $this->render('pages/admin/admin.html.twig');
    }

    /**
     * Pagr Admin, Read Users
     *
     * @param UserRepository $repository
     * @return Response
     */
    #[Route('/admin/users', name: 'app_admin_users')]
    public function readUsers(UserRepository $repository): Response
    {
        $users = $repository->findBy([], ['id' => 'DESC']);

        return $this->render('pages/admin/users.html.twig', compact('users'));
    }

    #[Route('/admin/users/delete/{id}', name: 'app_admin_users_delete')]
    public function deleteUsers(User $user, EntityManagerInterface $manager): Response
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash('success', 'The user have been successfully delete !');
        return $this->redirectToRoute('app_admin_users');
    }

    
    #[Route('/admin/read', name: 'app_contact_read', methods: ['GET'])]
    public function contactRead(ContactRepository $repository): Response
    {
        $contacts = $repository->findBy([], ['id' => 'DESC']);

        return $this->render('pages/contact/contact_read.html.twig', compact('contacts'));
    }

    #[Route('/admin/read/delete/{id}', name: 'app_contact_delete', methods: ['GET'])]
    public function contactDelete(Contact $contact, EntityManagerInterface $manager): Response
    {
        $manager->remove($contact);
        $manager->flush();

        $this->addFlash('success', 'The contact have been successfully delete !');
        return $this->redirectToRoute('app_contact_read');
    }

}
