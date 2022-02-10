<?php

namespace App\Entity;

use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
class Livreur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable:true)]
    private $LI_Nom;

    #[ORM\Column(type: 'string', length: 255, nullable:true)]
    private $LI_Prenom;

    #[ORM\Column(type: 'integer', nullable:true)]
    private $LI_Telephone;

    #[ORM\Column(type: 'string', length: 255)]
    private $LI_Mail;

    #[ORM\OneToMany(mappedBy: 'FK_LI', targetEntity: Vehicule::class)]
    private $vehicules;

    #[ORM\OneToMany(mappedBy: 'FK_LI', targetEntity: Commande::class)]
    private $commandes;

    #[ORM\ManyToOne(targetEntity: Ville::class, inversedBy: 'livreurs')]
    private $FK_VI;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'livreurs')]
    #[ORM\JoinColumn(nullable: false)]
    private $FK_US;

    public function __construct()
    {
        $this->vehicules = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLINom(): ?string
    {
        return $this->LI_Nom;
    }

    public function setLINom(string $LI_Nom): self
    {
        $this->LI_Nom = $LI_Nom;

        return $this;
    }

    public function getLIPrenom(): ?string
    {
        return $this->LI_Prenom;
    }

    public function setLIPrenom(string $LI_Prenom): self
    {
        $this->LI_Prenom = $LI_Prenom;

        return $this;
    }

    public function getLITelephone(): ?int
    {
        return $this->LI_Telephone;
    }

    public function setLITelephone(int $LI_Telephone): self
    {
        $this->LI_Telephone = $LI_Telephone;

        return $this;
    }

    public function getLIMail(): ?string
    {
        return $this->LI_Mail;
    }

    public function setLIMail(string $LI_Mail): self
    {
        $this->LI_Mail = $LI_Mail;

        return $this;
    }

    /**
     * @return Collection|Vehicule[]
     */
    public function getVehicules(): Collection
    {
        return $this->vehicules;
    }

    public function addVehicule(Vehicule $vehicule): self
    {
        if (!$this->vehicules->contains($vehicule)) {
            $this->vehicules[] = $vehicule;
            $vehicule->setFKLI($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicule $vehicule): self
    {
        if ($this->vehicules->removeElement($vehicule)) {
            // set the owning side to null (unless already changed)
            if ($vehicule->getFKLI() === $this) {
                $vehicule->setFKLI(null);
            }
        }

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
            $commande->setFKLI($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getFKLI() === $this) {
                $commande->setFKLI(null);
            }
        }

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

    public function getFKUS(): ?User
    {
        return $this->FK_US;
    }

    public function setFKUS(?User $FK_US): self
    {
        $this->FK_US = $FK_US;

        return $this;
    }

    public function __toString(){
        return $this->LI_Nom . " " . $this->LI_Prenom ;
    }

}