<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $RE_Libelle;

    #[ORM\Column(type: 'string', length: 255)]
    private $RE_Adresse;

    #[ORM\ManyToOne(targetEntity: Restaurateur::class, inversedBy: 'restaurants')]
    #[ORM\JoinColumn(nullable: false)]
    private $FK_RES_id;

    #[ORM\ManyToOne(targetEntity: Ville::class)]
    private $FK_VI_id;

    #[ORM\ManyToMany(targetEntity: Categories::class, mappedBy: 'FK_RE')]
    private $categories;

    #[ORM\OneToMany(mappedBy: 'FK_RE', targetEntity: Plat::class)]
    private $plats;

    #[ORM\OneToMany(mappedBy: 'FK_RE', targetEntity: HoraireRestaurant::class)]
    private $horaireRestaurants;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->plats = new ArrayCollection();
        $this->horaireRestaurants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRELibelle(): ?string
    {
        return $this->RE_Libelle;
    }

    public function setRELibelle(string $RE_Libelle): self
    {
        $this->RE_Libelle = $RE_Libelle;

        return $this;
    }

    public function getREAdresse(): ?string
    {
        return $this->RE_Adresse;
    }

    public function setREAdresse(string $RE_Adresse): self
    {
        $this->RE_Adresse = $RE_Adresse;

        return $this;
    }

    public function getFKRESId(): ?Restaurateur
    {
        return $this->FK_RES_id;
    }

    public function setFKRESId(?Restaurateur $FK_RES_id): self
    {
        $this->FK_RES_id = $FK_RES_id;

        return $this;
    }

    public function getFKVIId(): ?Ville
    {
        return $this->FK_VI_id;
    }

    public function setFKVIId(?Ville $FK_VI_id): self
    {
        $this->FK_VI_id = $FK_VI_id;

        return $this;
    }

    /**
     * @return Collection|Categories[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categories $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addFKRE($this);
        }

        return $this;
    }

    public function removeCategory(Categories $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeFKRE($this);
        }

        return $this;
    }

    /**
     * @return Collection|Plat[]
     */
    public function getPlats(): Collection
    {
        return $this->plats;
    }

    public function addPlat(Plat $plat): self
    {
        if (!$this->plats->contains($plat)) {
            $this->plats[] = $plat;
            $plat->setFKRE($this);
        }

        return $this;
    }

    public function removePlat(Plat $plat): self
    {
        if ($this->plats->removeElement($plat)) {
            // set the owning side to null (unless already changed)
            if ($plat->getFKRE() === $this) {
                $plat->setFKRE(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HoraireRestaurant[]
     */
    public function getHoraireRestaurants(): Collection
    {
        return $this->horaireRestaurants;
    }

    public function addHoraireRestaurant(HoraireRestaurant $horaireRestaurant): self
    {
        if (!$this->horaireRestaurants->contains($horaireRestaurant)) {
            $this->horaireRestaurants[] = $horaireRestaurant;
            $horaireRestaurant->setFKRE($this);
        }

        return $this;
    }

    public function removeHoraireRestaurant(HoraireRestaurant $horaireRestaurant): self
    {
        if ($this->horaireRestaurants->removeElement($horaireRestaurant)) {
            // set the owning side to null (unless already changed)
            if ($horaireRestaurant->getFKRE() === $this) {
                $horaireRestaurant->setFKRE(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->RE_Libelle;
    }

}