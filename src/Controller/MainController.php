<?php

namespace App\Controller;

use App\Repository\ImageRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

/**
 *  Page Main
 */
#[Route('/', name: 'app_main_')]
class MainController extends AbstractController
{
    /**
     * Page Main
     *
     * @param ImageRepository $image
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'index', methods: ['GET'])]
    public function main(ImageRepository $image, PaginatorInterface $paginator, Request $request): Response
    {
        $images = $paginator->paginate(
            $image->findAll(),
            $request->query->getInt('page', 1), /*page number*/ 8 /*limit per page*/
        );

        return $this->render('pages/main.html.twig', compact('images')); 
    }

    /**
     * Page Main, Paginate
     *
     * @param ImageRepository $image
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/loli/page/', name: 'loli', methods: ['GET'])]
    public function mainRead(ImageRepository $image, PaginatorInterface $paginator, Request $request): Response
    {
        $images = $paginator->paginate(
            $image->findAll(),
            $request->query->getInt('page', 1), /*page number*/ 8 /*limit per page*/
        );

        return $this->render('pages/main.html.twig', compact('images')); 
    }
}
