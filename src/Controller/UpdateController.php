<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use App\Entity\Contact;

class UpdateController extends AbstractController
{
    /**
     * @Route("/contact/update", name="update")
     */
    public function index(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $contact = $entityManager->getRepository(Contact::class)->find($_GET["id"]);

        if (!$contact) {
            throw $this->createNotFoundException(
                'No contact found for id '.$id
            );
        }

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $contact = $form->getData();
            $this->addFlash('success', 'Contact mis à jour');
            
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('annuaire');
        }

        return $this->render('update/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("contact/update/delete", name="contact_delete")
     */
    public function index2(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Contact::class);

        $contact = $repository->find($_GET["id"]);
        $entityManager->remove($contact);
        $entityManager->flush();
        return $this->redirectToRoute('annuaire');
    }
}
