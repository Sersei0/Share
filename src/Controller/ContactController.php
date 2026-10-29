<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\SupprContactType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;

final class ContactController extends AbstractController
{
    #[Route('/mod-liste_contacts', name: 'app_liste_contacts')]
    public function listeContacts(ContactRepository $contactRepository, Request $request, EntityManagerInterface $em): Response
    {
        $contacts = $contactRepository->findAll();

        $form = $this->createForm(SupprContactType::class, null, ['contacts'=>$contacts]);

        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $selectedContacts = $form->get('contacts')->getData();

                foreach ($selectedContacts as $contacts){
                    $em->remove($contacts);
                }
                $em->flush();
                $this->addFlash('notice', 'Contacts supprimés avec succès');

                return $this -> redirectToRoute('app_liste_contacts');
            }

        };
        
        return $this->render('contact/liste_contacts.html.twig', [
            'contacts' => $contacts, 'formSuprContacts' => $form->createView(),
        ]);
    }

    #[Route ('/mod-remContact/{id}', name: 'app_removeContact')]
    public function removeContact(Contact $contact, EntityManagerInterface $em) : Response {
        if ($contact != null){
            $em->remove($contact);
            $em->flush();
            $this->addFlash('notice', 'Contact supprimé');
        }
        return $this->redirectToRoute('app_liste_contacts');
    }
}
