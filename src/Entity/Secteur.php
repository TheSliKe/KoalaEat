<?php

namespace App\Entity;

use App\Repository\SecteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SecteurRepository::class)]
class Secteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $SE_Libelle;

    #[ORM\OneToMany(mappedBy: 'FK_SE_id', targetEntity: Ville::class)]
    private $FK_SE_id;

    public function __construct()
    {
        $this->FK_SE_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSELibelle(): ?string
    {
        return $this->SE_Libelle;
    }

    public function setSELibelle(string $SE_Libelle): self
    {
        $this->SE_Libelle = $SE_Libelle;

        return $this;
    }

    /**
     * @return Collection|Ville[]
     */
    public function getFKSEId(): Collection
    {
        return $this->FK_SE_id;
    }

    public function addFKSEId(Ville $fKSEId): self
    {
        if (!$this->FK_SE_id->contains($fKSEId)) {
            $this->FK_SE_id[] = $fKSEId;
            $fKSEId->setFKSEId($this);
        }

        return $this;
    }

    public function removeFKSEId(Ville $fKSEId): self
    {
        if ($this->FK_SE_id->removeElement($fKSEId)) {
            // set the owning side to null (unless already changed)
            if ($fKSEId->getFKSEId() === $this) {
                $fKSEId->setFKSEId(null);
            }
        }

        return $this;
    }
}
