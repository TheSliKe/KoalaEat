<?php

namespace App\Entity;

use App\Repository\PlatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlatRepository::class)]
class Plat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $PA_Libelle;

    #[ORM\Column(type: 'integer')]
    private $PA_Prix;

    #[ORM\Column(type: 'integer')]
    private $PA_Stock;

    #[ORM\ManyToOne(targetEntity: Restaurant::class, inversedBy: 'plats')]
    private $FK_RE;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'FK_PA')]
    private $commandes;


    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->commandePlats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPALibelle(): ?string
    {
        return $this->PA_Libelle;
    }

    public function setPALibelle(string $PA_Libelle): self
    {
        $this->PA_Libelle = $PA_Libelle;

        return $this;
    }

    public function getPAPrix(): ?int
    {
        return $this->PA_Prix;
    }

    public function setPAPrix(int $PA_Prix): self
    {
        $this->PA_Prix = $PA_Prix;

        return $this;
    }

    public function getPAStock(): ?int
    {
        return $this->PA_Stock;
    }

    public function setPAStock(int $PA_Stock): self
    {
        $this->PA_Stock = $PA_Stock;

        return $this;
    }

    public function getFKRE(): ?Restaurant
    {
        return $this->FK_RE;
    }

    public function setFKRE(?Restaurant $FK_RE): self
    {
        $this->FK_RE = $FK_RE;

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addFKPA($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeFKPA($this);
        }

        return $this;
    }

}
