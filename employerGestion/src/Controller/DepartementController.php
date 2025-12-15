<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Repository\DepartementRepository;

class DepartementController
{
    private DepartementRepository $departementRepository;

    public function __construct(DepartementRepository $departementRepository)
    {
        $this->departementRepository = $departementRepository;
    }

    public function ajouterDepartement(string $nom): Departement
    {
        $departement = new Departement();
        $departement->setNom($nom);
        
        return $this->departementRepository->save($departement);
    }

    public function listerDepartements(): array
    {
        return $this->departementRepository->findAll();
    }

    public function trouverDepartementParId(int $id): ?Departement
    {
        return $this->departementRepository->findById($id);
    }
}