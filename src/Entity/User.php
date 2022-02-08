<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'integer')]
    private $accountType;

    #[ORM\OneToMany(mappedBy: 'FK_US', targetEntity: Client::class)]
    private $clients;

    #[ORM\OneToMany(mappedBy: 'FK_US', targetEntity: Livreur::class)]
    private $livreurs;

    #[ORM\OneToMany(mappedBy: 'FK_US', targetEntity: Restaurateur::class)]
    private $restaurateurs;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->livreurs = new ArrayCollection();
        $this->restaurateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAccountType(): ?int
    {
        return $this->accountType;
    }

    public function setAccountType(int $accountType): self
    {
        $this->accountType = $accountType;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setFKUS($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getFKUS() === $this) {
                $client->setFKUS(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Livreur[]
     */
    public function getLivreurs(): Collection
    {
        return $this->livreurs;
    }

    public function addLivreur(Livreur $livreur): self
    {
        if (!$this->livreurs->contains($livreur)) {
            $this->livreurs[] = $livreur;
            $livreur->setFKUS($this);
        }

        return $this;
    }

    public function removeLivreur(Livreur $livreur): self
    {
        if ($this->livreurs->removeElement($livreur)) {
            // set the owning side to null (unless already changed)
            if ($livreur->getFKUS() === $this) {
                $livreur->setFKUS(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Restaurateur[]
     */
    public function getRestaurateurs(): Collection
    {
        return $this->restaurateurs;
    }

    public function addRestaurateur(Restaurateur $restaurateur): self
    {
        if (!$this->restaurateurs->contains($restaurateur)) {
            $this->restaurateurs[] = $restaurateur;
            $restaurateur->setFKUS($this);
        }

        return $this;
    }

    public function removeRestaurateur(Restaurateur $restaurateur): self
    {
        if ($this->restaurateurs->removeElement($restaurateur)) {
            // set the owning side to null (unless already changed)
            if ($restaurateur->getFKUS() === $this) {
                $restaurateur->setFKUS(null);
            }
        }

        return $this;
    }
}
