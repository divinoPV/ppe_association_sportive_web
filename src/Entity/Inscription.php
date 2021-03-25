<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 */
class Inscription
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="inscriptions")
     * @ORM\JoinColumn(name="utilisateur", nullable=false, referencedColumnName="id")
     */
    private User $utilisateur;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="inscriptions")
     * @ORM\JoinColumn(name="evenement", nullable=false, referencedColumnName="id")
     */
    private Evenement $evenement;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $creerLe;

    public function __construct()
    {
        $this->setCreerLe();
    }

    public function setCreerLe(): self
    {
        $this->creerLe = new DateTime();

        return $this;
    }

    public function getCreerLe(): ?DateTime
    {
        return $this->creerLe;
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
    public function getUtilisateur(): User
    {
        return $this->utilisateur;
    }

    /**
     * @param User $utilisateur
     * @return Inscription
     */
    public function setUtilisateur(User $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}