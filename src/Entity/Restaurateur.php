<?php

namespace App\Entity;

use App\Repository\RestaurateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurateurRepository::class)]
class Restaurateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable:true)]
    private $RES_Nom;

    #[ORM\Column(type: 'string', length: 255, nullable:true)]
    private $RES_Prenom;

    #[ORM\Column(type: 'integer', nullable:true)]
    private $RES_Telephone;

    #[ORM\Column(type: 'string', length: 255)]
    private $RES_Mail;

    #[ORM\OneToMany(mappedBy: 'FK_RES_id', targetEntity: Restaurant::class)]
    private $restaurants;

    #[ORM\Column(type: 'string', length: 255)]
    private $RES_adresse;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'restaurateurs')]
    #[ORM\JoinColumn(nullable: false)]
    private $FK_US;

    public function __construct()
    {
        $this->restaurants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRESNom(): ?string
    {
        return $this->RES_Nom;
    }

    public function setRESNom(string $RES_Nom): self
    {
        $this->RES_Nom = $RES_Nom;

        return $this;
    }

    public function getRESPrenom(): ?string
    {
        return $this->RES_Prenom;
    }

    public function setRESPrenom(string $RES_Prenom): self
    {
        $this->RES_Prenom = $RES_Prenom;

        return $this;
    }

    public function getRESTelephone(): ?int
    {
        return $this->RES_Telephone;
    }

    public function setRESTelephone(int $RES_Telephone): self
    {
        $this->RES_Telephone = $RES_Telephone;

        return $this;
    }

    public function getRESMail(): ?string
    {
        return $this->RES_Mail;
    }

    public function setRESMail(string $RES_Mail): self
    {
        $this->RES_Mail = $RES_Mail;

        return $this;
    }

    /**
     * @return Collection|Restaurant[]
     */
    public function getRestaurants(): Collection
    {
        return $this->restaurants;
    }

    public function addRestaurant(Restaurant $restaurant): self
    {
        if (!$this->restaurants->contains($restaurant)) {
            $this->restaurants[] = $restaurant;
            $restaurant->setFKRESId($this);
        }

        return $this;
    }

    public function removeRestaurant(Restaurant $restaurant): self
    {
        if ($this->restaurants->removeElement($restaurant)) {
            // set the owning side to null (unless already changed)
            if ($restaurant->getFKRESId() === $this) {
                $restaurant->setFKRESId(null);
            }
        }

        return $this;
    }

    public function getRESAdresse(): ?string
    {
        return $this->RES_adresse;
    }

    public function setRESAdresse(string $RES_adresse): self
    {
        $this->RES_adresse = $RES_adresse;

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
}
