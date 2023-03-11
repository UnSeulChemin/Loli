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
     * Page Main, Read Image
     *
     * @param Request $request
     * @param ImageRepository $image
     * @param PaginatorInterface $paginator
     * @return Response
     */
    #[Route('/', name: 'index', methods: ['GET'])]
    public function main(Request $request, ImageRepository $image, PaginatorInterface $paginator): Response
    {
        $images = $paginator->paginate(
            $image->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/ 8 /*limit per page*/
        );

        return $this->render('pages/main.html.twig', compact('images')); 
    }

    /**
     * Page Main, Read Image / Paginate
     *
     * @param Request $request
     * @param ImageRepository $image
     * @param PaginatorInterface $paginator
     * @return Response
     */
    #[Route('/loli/page/', name: 'loli', methods: ['GET'])]
    public function mainPaginate(Request $request, ImageRepository $image, PaginatorInterface $paginator): Response
    {
        $images = $paginator->paginate(
            $image->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/ 8 /*limit per page*/
        );

        return $this->render('pages/main.html.twig', compact('images')); 
    }
}