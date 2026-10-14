<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ImportType;
use App\Entity\Import;

final class BaseController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', []);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response //déclaration méthode avec pour nom about typée response
    {
        return $this->render('base/about.html.twig', []); //$this permet d'appeler la méthode render de abstractController et render construit un objet response (1er paramètre = nom du template, 2e paramètre = tableau php avec variable)
    }

    #[Route('/mentionsLegales', name: 'app_mentions')]
    public function mentions(): Response
    {
        return $this->render('base/mentions.html.twig', []);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, EntityManagerInterface $em): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        if ($request -> isMethod('POST')) {
            $form -> handleRequest($request);
            if ($form -> isSubmitted() && $form -> isValid()){
                $contact->setDateEnvoie(new \DateTimeImmutable());
                $em -> persist($contact);
                $em -> flush();
                $this -> addFlash('notice', 'Message envoyé');
                return $this -> redirectToRoute('app_contact');
            }
        }
        return $this->render('base/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/importation', name: 'app_import')]
    public function importation(Request $request, EntityManagerInterface $em): Response
    {
        $import = new Import();
        $form = $this->createForm(ImportType::class, $import);

        if ($request -> isMethod('POST'))
        {
            $form-> handleRequest($request);
            if ($form -> isSubmitted() && $form -> isValid())
            {
                $em -> persist($import);
                $em -> flush();
                $this -> addFlash('notice', 'Fichier déposé');
                return $this->redirectToRoute('app_import');
            }
        }

        return $this->render('base/importation.html.twig', ['ImportForm'=>$form->createView()]);
    }
}
