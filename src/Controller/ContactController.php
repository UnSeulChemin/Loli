<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact_create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
       $contact = new Contact();
       $form = $this->createForm(ContactFormType::class, $contact);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid())
       {
           $contact = $form->getData();

           $manager->persist($contact);
           $manager->flush();

           $this->addFlash('success', 'Your message have be succefully sent !');

           return $this->redirectToRoute('app_contact_create');
       }

       return $this->render('pages/contact/contact_create.html.twig', [
           'form' => $form,
       ]);
    }

    #[Route('/contact/read', name: 'app_contact_read', methods: ['GET'])]
    public function contactShow(ContactRepository $repository): Response
    {
        $contacts = $repository->findAll();

        return $this->render('pages/contact/contact_read.html.twig', compact('contacts'));
    }

}
