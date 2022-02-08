<?php

namespace App\Entity;

use App\Repository\ComposeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComposeRepository::class)]
class Compose
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $CO_Quantite;

    #[ORM\ManyToOne(targetEntity: Plat::class, inversedBy: 'composes')]
    #[ORM\JoinColumn(nullable: false)]
    private $FK_PA;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'composes')]
    private $FK_CO;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCOQuantite(): ?int
    {
        return $this->CO_Quantite;
    }

    public function setCOQuantite(int $CO_Quantite): self
    {
        $this->CO_Quantite = $CO_Quantite;

        return $this;
    }

    public function getFKPA(): ?Plat
    {
        return $this->FK_PA;
    }

    public function setFKPA(?Plat $FK_PA): self
    {
        $this->FK_PA = $FK_PA;

        return $this;
    }

    public function getFKCO(): ?Commande
    {
        return $this->FK_CO;
    }

    public function setFKCO(?Commande $FK_CO): self
    {
        $this->FK_CO = $FK_CO;

        return $this;
    }
}
