<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function admin(): Response
    {
        return $this->render('pages/admin/admin.html.twig');
    }

    #[Route('/admin/users', name: 'app_admin_users')]
    public function showUsers(UserRepository $repository): Response
    {
        $users = $repository->findBy([], ['id' => 'DESC']);

        return $this->render('pages/admin/users.html.twig', compact('users'));
    }
}
