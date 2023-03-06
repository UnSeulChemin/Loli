<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/', name: 'app_main_')]
class MainController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(ImageRepository $image, PaginatorInterface $paginator, Request $request): Response
    {
        $images = $paginator->paginate(
            $image->findAll(),
            $request->query->getInt('page', 1), /*page number*/ 8 /*limit per page*/
        );

        return $this->render('pages/main.html.twig', compact('images')); 
    }

    #[Route('/loli/page/', name: 'loli', methods: ['GET', 'POST'])]
    public function loli(ImageRepository $image, PaginatorInterface $paginator, Request $request): Response
    {
        $images = $paginator->paginate(
            $image->findAll(),
            $request->query->getInt('page', 1), /*page number*/ 8 /*limit per page*/
        );

        return $this->render('pages/main.html.twig', compact('images')); 
    }
}
