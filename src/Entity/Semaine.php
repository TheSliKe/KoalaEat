<?php

namespace App\Entity;

use App\Repository\SemaineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SemaineRepository::class)]
class Semaine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $SEM_Libelle;

    #[ORM\OneToMany(mappedBy: 'FK_SEM', targetEntity: HoraireRestaurant::class)]
    private $horaireRestaurants;

    public function __construct()
    {
        $this->horaireRestaurants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSEMLibelle(): ?string
    {
        return $this->SEM_Libelle;
    }

    public function setSEMLibelle(string $SEM_Libelle): self
    {
        $this->SEM_Libelle = $SEM_Libelle;

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
            $horaireRestaurant->setFKSEM($this);
        }

        return $this;
    }

    public function removeHoraireRestaurant(HoraireRestaurant $horaireRestaurant): self
    {
        if ($this->horaireRestaurants->removeElement($horaireRestaurant)) {
            // set the owning side to null (unless already changed)
            if ($horaireRestaurant->getFKSEM() === $this) {
                $horaireRestaurant->setFKSEM(null);
            }
        }

        return $this;
    }
}
