<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'FK_VI', targetEntity: Livreur::class)]
    private $livreurs;

    #[ORM\OneToMany(mappedBy: 'FK_VI', targetEntity: Client::class)]
    private $clients;

    public function __construct()
    {
        $this->livreurs = new ArrayCollection();
        $this->clients = new ArrayCollection();
    }

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

    /**
     * @return Collection|Livreur[]
     */
    public function getLivreurs(): Collection
    {
        return $this->livreurs;
    }

    public function addLivreur(Livreur $livreur): self
    {
        if (!$this->livreurs->contains($livreur)) {
            $this->livreurs[] = $livreur;
            $livreur->setFKVI($this);
        }

        return $this;
    }

    public function removeLivreur(Livreur $livreur): self
    {
        if ($this->livreurs->removeElement($livreur)) {
            // set the owning side to null (unless already changed)
            if ($livreur->getFKVI() === $this) {
                $livreur->setFKVI(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setFKVI($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getFKVI() === $this) {
                $client->setFKVI(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->VI_Libelle;
    }

}
