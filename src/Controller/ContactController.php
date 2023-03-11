<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Page Contact
 */
class ContactController extends AbstractController
{
    /**
     * Page Contact, Create
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/contact', name: 'app_contact_create', methods: ['GET', 'POST'])]
    public function contactCreate(Request $request, EntityManagerInterface $manager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $contact = $form->getData();

            $manager->persist($contact);
            $manager->flush();

            $this->addFlash('success', 'Your message have been successfully sent !');
            return $this->redirectToRoute('app_contact_create');
        }

        else if ($form->isSubmitted() && !$form->isValid())
        {
            $this->addFlash('warning', 'Complete the following step and try again.');
        }

       return $this->render('pages/contact/contact_create.html.twig', compact('form'));
    }
}