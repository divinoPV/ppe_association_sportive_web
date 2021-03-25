<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=256)
     * @Assert\NotBlank()
     */
    private string $nom;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="categorie")
     */
    private Collection $utilisateurs;

    /**
     * @ORM\OneToMany(targetEntity=Evenement::class, mappedBy="categorie", orphanRemoval=true)
     */
    private Collection $evenements;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->evenements = new ArrayCollection();
    }

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
    public function getEvenements(): ?Collection
    {
        return $this->evenements;
    }

    public function addEvenements(Evenement $evenements): self
    {
        if (!$this->evenements->contains($evenements)) {
            $this->evenements[] = $evenements;
            $evenements->setCategorie($this);
        }

        return $this;
    }

    public function removeEvenements(Evenement $evenements): self
    {
        if ($this->evenements->contains($evenements)) {
            $this->evenements->remove($evenements);
            // set the owning side to null (unless already changed)
            if ($evenements->getCategorie() === $this) {
                $evenements->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */

    public function getUtilisateurs(): ?Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateurs(User $utilisateurs): self
    {
        if (!$this->utilisateurs->contains($utilisateurs)) {
            $this->utilisateurs[] = $utilisateurs;

            $utilisateurs->setCategorie($this);
        }

        return $this;
    }

    public function removeUtilisateurs(User $utilisateurs): self
    {
        if ($this->utilisateurs->contains($utilisateurs)) {
            $this->utilisateurs->remove($utilisateurs);

            if ($utilisateurs->getCategorie() === $this) {
                $utilisateurs->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}