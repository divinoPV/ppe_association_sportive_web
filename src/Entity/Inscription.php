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
     * @ORM\ManyToOne(targetEntity=Eleve::class)
     * @ORM\JoinColumn(name="eleve", nullable=false, referencedColumnName="id")
     */
    private Eleve $eleve;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Evenement::class)
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

    public function getEleve(): ?Eleve
    {
        return $this->eleve;
    }

    public function setEleve(Eleve $eleve): self
    {
        $this->eleve = $eleve;

        return $this;
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
}