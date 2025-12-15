<?php

namespace App\Repository\Impl;

use App\Entity\Employe;
use App\Entity\Departement;
use App\Repository\EmployeRepository;

class EmployeRepositoryImpl implements EmployeRepository
{
    private static array $employes = [];
    private static int $compteur = 0;

    public function save(Employe $employe): Employe
    {
        if ($employe->getId() === 0) {
            self::$compteur++;
            $employe->setId(self::$compteur);
            self::$employes[$employe->getId()] = $employe;
        } else {
            self::$employes[$employe->getId()] = $employe;
        }
        return $employe;
    }

    public function findAll(): array
    {
        return array_values(self::$employes);
    }

    public function findByDepartement(Departement $departement): array
    {
        $result = [];
        foreach (self::$employes as $employe) {
            if ($employe->getDepartement()->getId() === $departement->getId()) {
                $result[] = $employe;
            }
        }
        return $result;
    }
}