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

    #[ORM\OneToMany(mappedBy: 'FK_CO', targetEntity: Compose::class)]
    private $composes;

    #[ORM\OneToMany(mappedBy: 'FK_CO', targetEntity: Possede::class)]
    private $possedes;

    public function __construct()
    {
        $this->FK_PA = new ArrayCollection();
        $this->commandePlats = new ArrayCollection();
        $this->composes = new ArrayCollection();
        $this->possedes = new ArrayCollection();
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

    /**
     * @return Collection|Compose[]
     */
    public function getComposes(): Collection
    {
        return $this->composes;
    }

    public function addCompose(Compose $compose): self
    {
        if (!$this->composes->contains($compose)) {
            $this->composes[] = $compose;
            $compose->setFKCO($this);
        }

        return $this;
    }

    public function removeCompose(Compose $compose): self
    {
        if ($this->composes->removeElement($compose)) {
            // set the owning side to null (unless already changed)
            if ($compose->getFKCO() === $this) {
                $compose->setFKCO(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Possede[]
     */
    public function getPossedes(): Collection
    {
        return $this->possedes;
    }

    public function addPossede(Possede $possede): self
    {
        if (!$this->possedes->contains($possede)) {
            $this->possedes[] = $possede;
            $possede->setFKCO($this);
        }

        return $this;
    }

    public function removePossede(Possede $possede): self
    {
        if ($this->possedes->removeElement($possede)) {
            // set the owning side to null (unless already changed)
            if ($possede->getFKCO() === $this) {
                $possede->setFKCO(null);
            }
        }

        return $this;
    }

}
