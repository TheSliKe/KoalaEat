<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $CL_Nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $CL_Prenom;

    #[ORM\Column(type: 'integer')]
    private $CL_Telephone;

    #[ORM\Column(type: 'string', length: 255)]
    private $CL_Mail;

    #[ORM\Column(type: 'string', length: 255)]
    private $CL_Adresse;

    #[ORM\ManyToOne(targetEntity: Ville::class, inversedBy: 'clients')]
    private $FK_VI;

    #[ORM\OneToMany(mappedBy: 'FK_CL', targetEntity: Commande::class)]
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCLNom(): ?string
    {
        return $this->CL_Nom;
    }

    public function setCLNom(string $CL_Nom): self
    {
        $this->CL_Nom = $CL_Nom;

        return $this;
    }

    public function getCLPrenom(): ?string
    {
        return $this->CL_Prenom;
    }

    public function setCLPrenom(string $CL_Prenom): self
    {
        $this->CL_Prenom = $CL_Prenom;

        return $this;
    }

    public function getCLTelephone(): ?int
    {
        return $this->CL_Telephone;
    }

    public function setCLTelephone(int $CL_Telephone): self
    {
        $this->CL_Telephone = $CL_Telephone;

        return $this;
    }

    public function getCLMail(): ?string
    {
        return $this->CL_Mail;
    }

    public function setCLMail(string $CL_Mail): self
    {
        $this->CL_Mail = $CL_Mail;

        return $this;
    }

    public function getCLAdresse(): ?string
    {
        return $this->CL_Adresse;
    }

    public function setCLAdresse(string $CL_Adresse): self
    {
        $this->CL_Adresse = $CL_Adresse;

        return $this;
    }

    public function getFKVI(): ?Ville
    {
        return $this->FK_VI;
    }

    public function setFKVI(?Ville $FK_VI): self
    {
        $this->FK_VI = $FK_VI;

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
            $commande->setFKCL($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getFKCL() === $this) {
                $commande->setFKCL(null);
            }
        }

        return $this;
    }
}
