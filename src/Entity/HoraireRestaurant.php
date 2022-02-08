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

    #[ORM\Column(type: 'time', nullable: true)]
    private $horaireDebutMidi;

    #[ORM\Column(type: 'time', nullable: true)]
    private $horaireFinMidi;

    #[ORM\Column(type: 'time', nullable: true)]
    private $horaireDebutSoir;

    #[ORM\Column(type: 'time', nullable: true)]
    private $horaireFinSoir;

    #[ORM\ManyToOne(targetEntity: Restaurant::class, inversedBy: 'horaireRestaurants')]
    #[ORM\JoinColumn(nullable: false)]
    private $FK_RE;

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
}
