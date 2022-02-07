<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $CA_Libelle;

    #[ORM\ManyToMany(targetEntity: Restaurant::class, inversedBy: 'categories')]
    private $FK_RE;

    public function __construct()
    {
        $this->FK_RE = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCALibelle(): ?string
    {
        return $this->CA_Libelle;
    }

    public function setCALibelle(string $CA_Libelle): self
    {
        $this->CA_Libelle = $CA_Libelle;

        return $this;
    }

    /**
     * @return Collection|Restaurant[]
     */
    public function getFKRE(): Collection
    {
        return $this->FK_RE;
    }

    public function addFKRE(Restaurant $fKRE): self
    {
        if (!$this->FK_RE->contains($fKRE)) {
            $this->FK_RE[] = $fKRE;
        }

        return $this;
    }

    public function removeFKRE(Restaurant $fKRE): self
    {
        $this->FK_RE->removeElement($fKRE);

        return $this;
    }
}
