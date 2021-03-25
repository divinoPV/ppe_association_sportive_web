<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=256)
     * @Assert\NotBlank()
     */
    private string $nom;

    /**
     * @ORM\OneToMany(targetEntity=Evenement::class, mappedBy="sport", orphanRemoval=true)
     */
    private Collection $evenements;

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
            $evenements->setSport($this);
        }

        return $this;
    }

    public function removeEvenements(Evenement $evenements): self
    {
        if ($this->evenements->contains($evenements)) {
            $this->evenements->remove($evenements);
            // set the owning side to null (unless already changed)
            if ($evenements->getSport() === $this) {
                $evenements->setSport(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}