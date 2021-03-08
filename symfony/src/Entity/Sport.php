<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SportRepository::class)
 */
class Sport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private string $nom;

    /**
     * @ORM\OneToMany(targetEntity=Evenement::class, mappedBy="sport")
     */
    private Collection $evenement;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvenement(): ?Collection
    {
        return $this->evenement;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenement->contains($evenement)) {
            $this->evenement[] = $evenement;
            $evenement->setSport($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenement->contains($evenement)) {
            $this->evenement->remove($evenement);
            // set the owning side to null (unless already changed)
            if ($evenement->getSport() === $this) {
                $evenement->setSport(null);
            }
        }

        return $this;
    }
}