<?php

namespace App\Entity;

use App\Repository\DocumentCategorieRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DocumentCategorieRepository::class)
 */
class DocumentCategorie
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
    private ?string $nom = null;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="categorie")
     */
    private Collection $documents;

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
     * @param string|null $nom
     */
    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocument(): ?Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $documents): self
    {
        if (!$this->documents->contains($documents)) {
            $this->documents[] = $documents;
            $documents->setCategorie($this);
        }

        return $this;
    }

    public function removeDocument(Document $documents): self
    {
        if ($this->documents->contains($documents)) {
            $this->documents->remove($documents);
            // set the owning side to null (unless already changed)
            if ($documents->getCategorie() === $this) {
                $documents->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}