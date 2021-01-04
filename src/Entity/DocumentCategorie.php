<?php

namespace App\Entity;

use App\Repository\DocumentCategorieRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private string $nom;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="document")
     */
    private Collection $document;

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
     * @return Collection|Document[]
     */
    public function getInscription(): ?Collection
    {
        return $this->document;
    }

    public function addInscription(Document $document): self
    {
        if (!$this->document->contains($document)) {
            $this->document[] = $document;
            $document->setCategorie($this);
        }

        return $this;
    }

    public function removeInscription(Document $document): self
    {
        if ($this->document->contains($document)) {
            $this->document->remove($document);
            // set the owning side to null (unless already changed)
            if ($document->getCategorie() === $this) {
                $document->setCategorie(null);
            }
        }

        return $this;
    }
}