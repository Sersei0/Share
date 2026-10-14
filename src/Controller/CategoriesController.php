<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CategoriesType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categories;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoriesRepository;
use App\Form\ModifyCategorieType;

final class CategoriesController extends AbstractController
{
    #[Route('/depot_categories', name: 'app_depot_categories')]
    public function depotCategories(Request $resquest, EntityManagerInterface $em): Response
    {
        $categorie = new Categories();
        $form = $this->createForm(CategoriesType::class, $categorie);

        if ($resquest -> isMethod('POST')){
            
            $form -> handleRequest($resquest);
            if ($form -> isSubmitted() && $form -> isValid()){
                $em -> persist($categorie);
                $em -> flush();
                $this -> addFlash('notice', 'Nouvelle catégorie enregistrée');
                return $this->redirectToRoute('app_depot_liste_categories');
            }
        }

        return $this->render('categories/depot_categories.html.twig', ['CategoriesForm' => $form -> createView()]);
    }

    #[Route('/depot_liste_categories', name: 'app_depot_liste_categories')]
    public function depotListeCategories(CategoriesRepository $categoriesRepository) : Response
    {
        $categorie = $categoriesRepository->findAll();
        return $this->render('categories/depot_liste_categories.html.twig', ['categories' => $categorie]);
    }

    #[Route('/modify_categorie/{id}', name: 'app_modify_categorie')]
    public function modifyCategorie(Categories $categorie, Request $request, EntityManagerInterface $em) : Response
    {
        $form = $this->createForm(ModifyCategorieType::class, $categorie);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request); #hydrate l'objet request

            if ($form->isSubmitted() && $form->isValid())
            {
                $em-> persist($categorie);
                $em-> flush();

                $this->addFlash('notice', 'Catégorie modifiée');

                return $this->redirectToRoute('app_depot_liste_categories');
            }
        }

        return $this->render('categories/modifyCategorie.html.twig', ['modifForm' => $form->createView(),]);
    }

    #[Route('/remCategorie/{id}', name: 'app_removeCategorie')]
    public function removeCategorie(Categories $categorie, EntityManagerInterface $em) : Response
    {
        if ($categorie != null){
            $em->remove($categorie);
            $em->flush();
            $this->addFlash('notice','Catégorie supprimée');
        }
        return $this->redirectToRoute('app_depot_liste_categories');
    }
}
