<?php

namespace App\Entity;

use App\Repository\HoraireRestaurantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HoraireRestaurantRepository::class)]
class HoraireRestaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $horaireDebutMidi;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $horaireFinMidi;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $horaireDebutSoir;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $horaireFinSoir;

    #[ORM\ManyToOne(targetEntity: Restaurant::class, inversedBy: 'horaireRestaurants')]
    #[ORM\JoinColumn(nullable: false)]
    private $FK_RE;

    #[ORM\ManyToOne(targetEntity: Semaine::class, inversedBy: 'horaireRestaurants')]
    private $FK_SEM;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHoraireDebutMidi(): ?\DateTimeInterface
    {
        return $this->horaireDebutMidi;
    }

    public function setHoraireDebutMidi(?\DateTimeInterface $horaireDebutMidi): self
    {
        $this->horaireDebutMidi = $horaireDebutMidi;

        return $this;
    }

    public function getHoraireFinMidi(): ?\DateTimeInterface
    {
        return $this->horaireFinMidi;
    }

    public function setHoraireFinMidi(?\DateTimeInterface $horaireFinMidi): self
    {
        $this->horaireFinMidi = $horaireFinMidi;

        return $this;
    }

    public function getHoraireDebutSoir(): ?\DateTimeInterface
    {
        return $this->horaireDebutSoir;
    }

    public function setHoraireDebutSoir(?\DateTimeInterface $horaireDebutSoir): self
    {
        $this->horaireDebutSoir = $horaireDebutSoir;

        return $this;
    }

    public function getHoraireFinSoir(): ?\DateTimeInterface
    {
        return $this->horaireFinSoir;
    }

    public function setHoraireFinSoir(?\DateTimeInterface $horaireFinSoir): self
    {
        $this->horaireFinSoir = $horaireFinSoir;

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

    public function getFKSEM(): ?Semaine
    {
        return $this->FK_SEM;
    }

    public function setFKSEM(?Semaine $FK_SEM): self
    {
        $this->FK_SEM = $FK_SEM;

        return $this;
    }
}
