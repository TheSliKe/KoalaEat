<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
class Vehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $VE_Libelle;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $VE_Immatriculation;

    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'vehicules')]
    private $FK_LI;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVELibelle(): ?string
    {
        return $this->VE_Libelle;
    }

    public function setVELibelle(string $VE_Libelle): self
    {
        $this->VE_Libelle = $VE_Libelle;

        return $this;
    }

    public function getVEImmatriculation(): ?string
    {
        return $this->VE_Immatriculation;
    }

    public function setVEImmatriculation(?string $VE_Immatriculation): self
    {
        $this->VE_Immatriculation = $VE_Immatriculation;

        return $this;
    }

    public function getFKLI(): ?Livreur
    {
        return $this->FK_LI;
    }

    public function setFKLI(?Livreur $FK_LI): self
    {
        $this->FK_LI = $FK_LI;

        return $this;
    }
}
