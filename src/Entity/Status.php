<?php

namespace App\Entity;

use App\Repository\StatusRepository;
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
}
