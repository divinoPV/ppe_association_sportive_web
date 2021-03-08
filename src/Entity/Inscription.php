<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 */
class Inscription
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="inscription")
     * @ORM\JoinColumn(name="user", nullable=false, referencedColumnName="id")
     */
    private User $user;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="inscription")
     * @ORM\JoinColumn(name="evenement", nullable=false, referencedColumnName="id")
     */
    private Evenement $evenement;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $creer;


    public function setCreatedAt(): self
    {
        $this->creer = new \DateTime();

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->creer;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(Evenement $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}