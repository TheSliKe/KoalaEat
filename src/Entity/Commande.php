<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $CO_AdresseDeLivraison;

    #[ORM\ManyToMany(targetEntity: Plat::class, inversedBy: 'commandes')]
    private $FK_PA;

    public function __construct()
    {
        $this->FK_PA = new ArrayCollection();
        $this->commandePlats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCOAdresseDeLivraison(): ?string
    {
        return $this->CO_AdresseDeLivraison;
    }

    public function setCOAdresseDeLivraison(string $CO_AdresseDeLivraison): self
    {
        $this->CO_AdresseDeLivraison = $CO_AdresseDeLivraison;

        return $this;
    }

    /**
     * @return Collection|Plat[]
     */
    public function getFKPA(): Collection
    {
        return $this->FK_PA;
    }

    public function addFKPA(Plat $fKPA): self
    {
        if (!$this->FK_PA->contains($fKPA)) {
            $this->FK_PA[] = $fKPA;
        }

        return $this;
    }

    public function removeFKPA(Plat $fKPA): self
    {
        $this->FK_PA->removeElement($fKPA);

        return $this;
    }

}
