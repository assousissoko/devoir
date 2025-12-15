<?php

namespace App\Repository;

use App\Entity\Departement;

interface DepartementRepository
{
    public function save(Departement $departement): Departement;
    public function findAll(): array;
    public function findById(int $id): ?Departement;
}