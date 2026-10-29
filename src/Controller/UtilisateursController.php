<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\TrieUserType;

final class UtilisateursController extends AbstractController
{
    #[Route('/admin-utilisateurs-liste', name: 'app_listeUtilisateurs')]
    public function listeUsers(UserRepository $userRepository, Request $request, EntityManagerInterface $em): Response
    {
        $listeUsers = $userRepository->findAll();

        $form = $this->createForm(TrieUserType::class, null, []);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){

                $listeUsers = $userRepository->findBy([], ['DateInscription'=> 'DESC']);

                $this->addFlash('notice', 'Trie par ordre décroissant des inscriptions effectué');
            }
        }

        return $this->render('utilisateurs/usersListe.html.twig', [
            'controller_name' => 'UtilisateursController', 'listeUser' => $listeUsers, 'trieUser' => $form->createView(),
        ]);
    }
}
