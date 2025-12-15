<?php

namespace App\Repository\Impl;

use App\Entity\Departement;
use App\Repository\DepartementRepository;

class DepartementRepositoryImpl implements DepartementRepository
{
    private static array $departements = [];
    private static int $compteur = 0;

    public function save(Departement $departement): Departement
    {
        if ($departement->getId() === 0) {
            self::$compteur++;
            $departement->setId(self::$compteur);
            self::$departements[$departement->getId()] = $departement;
        } else {
            self::$departements[$departement->getId()] = $departement;
        }
        return $departement;
    }

    public function findAll(): array
    {
        return array_values(self::$departements);
    }

    public function findById(int $id): ?Departement
    {
        return self::$departements[$id] ?? null;
    }
}