<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
     * @ORM\OneToMany(targetEntity=Evenement::class, mappedBy="categorie")
     */
    private Collection $evenement;

    /**
     * @ORM\OneToMany(targetEntity=Eleve::class, mappedBy="categorie")
     */
    private Collection $eleve;

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
            $evenement->setCategorie($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenement->contains($evenement)) {
            $this->evenement->remove($evenement);
            // set the owning side to null (unless already changed)
            if ($evenement->getCategorie() === $this) {
                $evenement->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Eleve[]
     */
    public function getEleve(): ?Collection
    {
        return $this->eleve;
    }

    public function addEleve(Eleve $eleve): self
    {
        if (!$this->eleve->contains($eleve)) {
            $this->eleve[] = $eleve;
            $eleve->setCategorie($this);
        }

        return $this;
    }

    public function removeEleve(Eleve $eleve): self
    {
        if ($this->eleve->contains($eleve)) {
            $this->eleve->remove($eleve);
            // set the owning side to null (unless already changed)
            if ($eleve->getCategorie() === $this) {
                $eleve->setCategorie(null);
            }
        }

        return $this;
    }
}