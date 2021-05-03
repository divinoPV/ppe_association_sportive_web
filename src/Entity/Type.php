<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TypeRepository::class)
 */
class Type
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private ?string $nom = null;

    /**
     * @ORM\OneToMany(targetEntity=Evenement::class, mappedBy="type")
     */
    private Collection $evenements;

    /**
     * @Assert\NotBlank(message="Veuillez saisir une couleur")
     * @ORM\Column(type="string", length=7)
     */
    private string $color;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenements(Evenement $evenements): self
    {
        if (!$this->evenements->contains($evenements)) {
            $this->evenements[] = $evenements;
            $evenements->setType($this);
        }

        return $this;
    }

    public function removeEvenements(Evenement $evenements): self
    {
        if ($this->evenements->removeElement($evenements)) {
            // set the owning side to null (unless already changed)
            if ($evenements->getType() === $this) {
                $evenements->setType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }
}