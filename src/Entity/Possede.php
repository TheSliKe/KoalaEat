<?php

namespace App\Entity;

use App\Repository\PossedeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PossedeRepository::class)]
class Possede
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $PO_date;

    #[ORM\ManyToOne(targetEntity: Status::class, inversedBy: 'possedes')]
    private $FK_ST;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'possedes')]
    private $FK_CO;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPODate(): ?\DateTimeInterface
    {
        return $this->PO_date;
    }

    public function setPODate(\DateTimeInterface $PO_date): self
    {
        $this->PO_date = $PO_date;

        return $this;
    }

    public function getFKST(): ?Status
    {
        return $this->FK_ST;
    }

    public function setFKST(?Status $FK_ST): self
    {
        $this->FK_ST = $FK_ST;

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
