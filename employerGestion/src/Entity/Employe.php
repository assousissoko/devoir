<?php

namespace App\Entity;

class Employe
{
    private int $id;
    private string $nom;
    private string $tel;
    private Specialite $specialite;
    private Departement $departement;

    public function __construct(int $id = 0, string $nom = "", string $tel = "")
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->tel = $tel;
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

    public function getTel(): string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;
        return $this;
    }

    public function getSpecialite(): Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(Specialite $specialite): self
    {
        $this->specialite = $specialite;
        return $this;
    }

    public function getDepartement(): Departement
    {
        return $this->departement;
    }

    public function setDepartement(Departement $departement): self
    {
        $this->departement = $departement;
        return $this;
    }
}