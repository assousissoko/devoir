<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Entity\Employe;
use App\Entity\Specialite;
use App\Repository\EmployeRepository;
use App\Repository\DepartementRepository;

class EmployeController
{
    private EmployeRepository $employeRepository;
    private DepartementRepository $departementRepository;

    public function __construct(
        EmployeRepository $employeRepository,
        DepartementRepository $departementRepository
    ) {
        $this->employeRepository = $employeRepository;
        $this->departementRepository = $departementRepository;
    }

    public function ajouterEmploye(string $nom, string $tel, Specialite $specialite, int $departementId): Employe
    {
        // 1. Trouver le département
        $departement = $this->departementRepository->findById($departementId);
        
        if ($departement === null) {
            throw new \Exception("Département introuvable avec l'ID $departementId");
        }

        // 2. Créer l'employé
        $employe = new Employe();
        $employe->setNom($nom)
                ->setTel($tel)
                ->setSpecialite($specialite)
                ->setDepartement($departement);

        // 3. Sauvegarder l'employé
        $employeSauvegarde = $this->employeRepository->save($employe);

        // 4. Mise à jour de la relation bidirectionnelle (liste dans l'objet Departement)
        $departement->addEmploye($employeSauvegarde);
        
        return $employeSauvegarde;
    }

    public function listerEmployesParDepartement(int $departementId): array
    {
        $departement = $this->departementRepository->findById($departementId);
        
        if ($departement === null) {
            return [];
        }

        // Le repository Employe gère la recherche
        return $this->employeRepository->findByDepartement($departement);
    }
}