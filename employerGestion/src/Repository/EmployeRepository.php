<?php

namespace App\Repository;

use App\Entity\Employe;
use App\Entity\Departement;

interface EmployeRepository
{
    public function save(Employe $employe): Employe;
    public function findAll(): array;
    public function findByDepartement(Departement $departement): array;
}