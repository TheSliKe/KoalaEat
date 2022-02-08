<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $ST_Libelle;

    #[ORM\OneToMany(mappedBy: 'FK_ST', targetEntity: Possede::class)]
    private $possedes;

    public function __construct()
    {
        $this->possedes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSTLibelle(): ?string
    {
        return $this->ST_Libelle;
    }

    public function setSTLibelle(string $ST_Libelle): self
    {
        $this->ST_Libelle = $ST_Libelle;

        return $this;
    }

    /**
     * @return Collection|Possede[]
     */
    public function getPossedes(): Collection
    {
        return $this->possedes;
    }

    public function addPossede(Possede $possede): self
    {
        if (!$this->possedes->contains($possede)) {
            $this->possedes[] = $possede;
            $possede->setFKST($this);
        }

        return $this;
    }

    public function removePossede(Possede $possede): self
    {
        if ($this->possedes->removeElement($possede)) {
            // set the owning side to null (unless already changed)
            if ($possede->getFKST() === $this) {
                $possede->setFKST(null);
            }
        }

        return $this;
    }
}
