<?php

declare(strict_types=1);

use App\Controller\DepartementController;
use App\Controller\EmployeController;
use App\Entity\Specialite;
use App\Repository\Impl\DepartementRepositoryImpl;
use App\Repository\Impl\EmployeRepositoryImpl;

// 1. Inclusion de l'autoloader
require dirname(__DIR__) . '/vendor/autoload.php';

// 2. Initialisation des Repositories et Controllers (Injection Manuelle des dépendances)
$departementRepository = new DepartementRepositoryImpl();
$employeRepository = new EmployeRepositoryImpl();

// Les Controllers sont instanciés en injectant leurs dépendances (Repositories)
$departementController = new DepartementController($departementRepository);
$employeController = new EmployeController($employeRepository, $departementRepository);

// --- Fonctions utilitaires CLI ---

function afficherMenu(): void
{
    echo "--- GESTION DES EMPLOYES (CLI) ---\n";
    echo "1. Ajouter un Département\n";
    echo "2. Lister tous les Départements\n";
    echo "3. Ajouter un Employé\n";
    echo "4. Lister les Employés d'un Département\n";
    echo "5. Quitter\n";
    echo "------------------------------------\n";
}

function lireSaisie(string $invite): string
{
    $saisie = readline($invite);
    if ($saisie === false) {
        return "";
    }
    return trim($saisie);
}

function listerDepartementsPourChoix(DepartementController $controller): void
{
    $departements = $controller->listerDepartements();
    
    if (empty($departements)) {
        echo "Aucun département enregistré.\n";
        return;
    }

    echo "\n--- Liste des Départements ---\n";
    foreach ($departements as $dept) {
        echo $dept->getId() . " : " . $dept->getNom() . "\n";
    }
    echo "------------------------------\n";
}


// --- Boucle principale de l'application CLI ---

$running = true;
while ($running) {
    afficherMenu();
    $choix = lireSaisie("Entrez votre choix (1-5) : ");

    switch ($choix) {
        case '1':
            echo "\n--- Ajout d'un Département ---\n";
            $nom = lireSaisie("Nom du département : ");
            
            if (!empty($nom)) {
                $dept = $departementController->ajouterDepartement($nom);
                echo "Département " . $dept->getNom() . " (ID: " . $dept->getId() . ") ajouté avec succès.\n\n";
            } else {
                echo "Le nom du département ne peut pas être vide.\n\n";
            }
            break;

        case '2':
            echo "\n--- Liste de tous les Départements ---\n";
            listerDepartementsPourChoix($departementController);
            echo "\n";
            break;

        case '3':
            echo "\n--- Ajout d'un Employé ---\n";
            listerDepartementsPourChoix($departementController);

            $idDepartement = (int) lireSaisie("ID du Département pour l'employé : ");
            $departement = $departementController->trouverDepartementParId($idDepartement);

            if ($departement === null) {
                echo "Département ID " . $idDepartement . " introuvable. Annulation de l'ajout.\n\n";
                break;
            }

            $nom = lireSaisie("Nom de l'employé : ");
            $tel = lireSaisie("Téléphone : ");
            
            echo "Spécialités disponibles (FullStack, Back-End, Front-End) : ";
            $specialiteInput = lireSaisie("Spécialité : ");
            
            try {
                // Utilisation de l'Enum pour valider la saisie de spécialité
                $specialite = Specialite::from($specialiteInput);
                
                $employe = $employeController->ajouterEmploye($nom, $tel, $specialite, $idDepartement);
                echo "Employé " . $employe->getNom() . " (ID: " . $employe->getId() . ") ajouté au département " . $departement->getNom() . ".\n\n";

            } catch (\ValueError $e) {
                echo "Spécialité '$specialiteInput' invalide. Veuillez choisir FullStack, Back-End ou Front-End (sensible à la casse).\n\n";
            } catch (\Exception $e) {
                // Pour capturer l'exception si le département est introuvable (bien que déjà vérifié, c'est une bonne pratique)
                echo "ERREUR: " . $e->getMessage() . "\n\n";
            }
            break;

        case '4':
            echo "\n--- Liste des Employés par Département ---\n";
            listerDepartementsPourChoix($departementController);

            $idDepartement = (int) lireSaisie("ID du Département pour le listing : ");
            $departement = $departementController->trouverDepartementParId($idDepartement);
            
            if ($departement === null) {
                echo "Département ID " . $idDepartement . " introuvable.\n\n";
                break;
            }

            $employes = $employeController->listerEmployesParDepartement($idDepartement);

            if (empty($employes)) {
                echo "Le département " . $departement->getNom() . " n'a aucun employé.\n";
            } else {
                echo "\n--- Employés du département " . $departement->getNom() . " ---\n";
                foreach ($employes as $emp) {
                    echo "ID: " . $emp->getId() . " | Nom: " . $emp->getNom() . " | Tél: " . $emp->getTel() . " | Spécialité: " . $emp->getSpecialite()->value . "\n";
                }
                echo "------------------------------------------------\n";
            }
            echo "\n";
            break;

        case '5':
            echo "Au revoir !\n";
            $running = false;
            break;

        default:
            echo "Choix invalide. Veuillez entrer un numéro entre 1 et 5.\n\n";
            break;
    }
}