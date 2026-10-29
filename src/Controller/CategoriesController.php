<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categories;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoriesRepository;
use App\Form\CategoriesType;
use App\Form\ModifyCategorieType;
use App\Form\SupprCategorieType;

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

    #[Route('/private-depot_liste_categories', name: 'app_depot_liste_categories')]
    public function depotListeCategories(CategoriesRepository $categoriesRepository, Request $request, EntityManagerInterface $em) : Response
    {
        $categorie = $categoriesRepository->findAll();

        $form = $this->createForm(SupprCategorieType::class, null, ['categories'=>$categorie]);
        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $selectedCategories = $form->get('categories')->getData(); /*dans mon formulaire, tout ce qui est selectionné, je récupère les données de catégories*/
                foreach($selectedCategories as $categorie){
                    $em->remove($categorie);
                }
                $em->flush();
                $this->addFlash('notice','Catégories supprimées avec succès');

                return $this->redirectToRoute('app_depot_liste_categories');
            }
        }
        
        return $this->render('categories/depot_liste_categories.html.twig', ['categories' => $categorie, 'form_supprMultiple'=>$form->createView(),]);
    }

    #[Route('/private-modify_categorie/{id}', name: 'app_modify_categorie')]
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

    #[Route('/private-remCategorie/{id}', name: 'app_removeCategorie')]
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
