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
     * Page Admin, Read Users
     *
     * @param UserRepository $repository
     * @return Response
     */
    #[Route('/admin/users', name: 'app_admin_users', methods: ['GET'])]
    public function readUsers(UserRepository $repository): Response
    {
        $users = $repository->findBy([], ['id' => 'DESC']);

        return $this->render('pages/admin/users.html.twig', compact('users'));
    }

    /**
     * Page Admin, Delete Users
     *
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return Response
     */    
    #[Route('/admin/users/delete/{id}', name: 'app_admin_users_delete', methods: ['GET'])]
    public function deleteUsers(User $user, EntityManagerInterface $manager): Response
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash('success', 'The user have been successfully delete !');
        return $this->redirectToRoute('app_admin_users');
    }

    /**
     * Page Admin, Read Contacts
     *
     * @param ContactRepository $repository
     * @return Response
     */    
    #[Route('/admin/contacts', name: 'app_admin_contacts', methods: ['GET'])]
    public function readContacts(ContactRepository $repository): Response
    {
        $contacts = $repository->findBy([], ['id' => 'DESC']);

        return $this->render('pages/admin/contacts.html.twig', compact('contacts'));
    }

    /**
     * Page Admin, Delete Contacts
     *
     * @param Contact $contact
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/admin/contacts/delete/{id}', name: 'app_admin_contacts_delete', methods: ['GET'])]
    public function deleteContacts(Contact $contact, EntityManagerInterface $manager): Response
    {
        $manager->remove($contact);
        $manager->flush();

        $this->addFlash('success', 'The contact have been successfully delete !');
        return $this->redirectToRoute('app_admin_contacts');
    }
}