<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
    public function contact(): Response
    {
        return $this->render('base/contact.html.twig', []);
    }
}
