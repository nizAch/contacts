<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use App\Entity\Contact;

class ContactsController extends AbstractController
{
    /**
     * @Route("/contacts", name="contacts")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();

        if($form->isSubmitted() and $form->isValid()){
            $contactFormData = $form->getData();
            
            $contact = new Contact();
            $contact->setFirstname($contactFormData['firstName']);
            $contact->setLastname($contactFormData['lastName']);
            $contact->setEmail($contactFormData['email']);
            $contact->setPhonenumber($contactFormData['number']);

            $entityManager->persist($contact);
            $entityManager->flush();

            $this->addFlash('success', 'Contact ajouté');

            return $this->redirectToRoute('contacts');
        }

        return $this->render('contact/index.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
