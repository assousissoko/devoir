<?php

namespace App\Entity;

class Departement
{
    private int $id;
    private string $nom;
    private array $employes = [];

    public function __construct(int $id = 0, string $nom = "")
    {
        $this->id = $id;
        $this->nom = $nom;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getEmployes(): array
    {
        return $this->employes;
    }

    public function addEmploye(Employe $employe): self
    {
        $this->employes[] = $employe;
        return $this;
    }
}