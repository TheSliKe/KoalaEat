<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $VI_Libelle;

    #[ORM\ManyToOne(targetEntity: Secteur::class, inversedBy: 'FK_SE_id')]
    #[ORM\JoinColumn(nullable: false)]
    private $FK_SE_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVILibelle(): ?string
    {
        return $this->VI_Libelle;
    }

    public function setVILibelle(string $VI_Libelle): self
    {
        $this->VI_Libelle = $VI_Libelle;

        return $this;
    }

    public function getFKSEId(): ?Secteur
    {
        return $this->FK_SE_id;
    }

    public function setFKSEId(?Secteur $FK_SE_id): self
    {
        $this->FK_SE_id = $FK_SE_id;

        return $this;
    }

    public function __toString(){
        return $this->VI_Libelle;
    }
}