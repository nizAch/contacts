<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use App\Entity\Contact;

class AnnuaireController extends AbstractController
{
    /**
     * @Route("/annuaire", name="annuaire")
     */
    public function index(): Response
    {

        $contacts = $this->getDoctrine()->getRepository(Contact::class)->findAll();

        return $this->render('annuaire/index.html.twig', [
            'annuaire' => $contacts,
        ]);
    }
}
