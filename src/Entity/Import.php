<?php

namespace App\Entity;

use App\Repository\ImportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImportRepository::class)]
class Import
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $nom = null;

    #[ORM\Column(length: 30)]
    private ?string $categorieFile = null;

    #[ORM\Column(type: Types::BLOB)]
    private mixed $Fichier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCategorieFile(): ?string
    {
        return $this->categorieFile;
    }

    public function setCategorieFile(string $categorieFile): static
    {
        $this->categorieFile = $categorieFile;

        return $this;
    }

    public function getFichier(): mixed
    {
        return $this->Fichier;
    }

    public function setFichier(mixed $Fichier): static
    {
        $this->Fichier = $Fichier;

        return $this;
    }
}
