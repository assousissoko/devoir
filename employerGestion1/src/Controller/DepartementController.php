<?php

namespace App\Controller;

use App\Entity\Departement; 
use App\Form\DepartementType; 
use Doctrine\ORM\EntityManagerInterface; 
use App\Repository\DepartementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DepartementController extends AbstractController
{
    #[Route('/departement', name: 'app_departement_index', methods: ['GET'])]
    public function index(DepartementRepository $departementRepository): Response
    {
        return $this->render('departement/index.html.twig', [
            'departements' => $departementRepository->findAll(),
        ]);
    }

    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $departement = new Departement();
        
        // 1. Création du Formulaire
        $form = $this->createForm(DepartementType::class, $departement);
        
        // 2. Traitement de la Requête (Handle Request)
        $form->handleRequest($request);

        // 3. Validation et Sauvegarde
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($departement);
            $entityManager->flush();

            // Ajout d'un message flash de succès
            $this->addFlash('success', 'Le nouveau département a été enregistré avec succès !');

            // Redirection vers la liste
            return $this->redirectToRoute('app_departement_index', [], Response::HTTP_SEE_OTHER);
        }

        // 4. Affichage du Formulaire
        return $this->render('departement/new.html.twig', [
            'departement' => $departement,
            'form' => $form,
        ]);
    }
}