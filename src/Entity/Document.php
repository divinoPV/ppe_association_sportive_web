<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Document
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
     * @ORM\Column(type="string", length=256)
     */
    private string $lien;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private string $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $creer;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $modifier;

    /**
     * @ORM\ManyToOne(targetEntity=DocumentCategorie::class, inversedBy="document")
     * @ORM\JoinColumn(name="categorie", nullable=false, referencedColumnName="id")
     */
    private DocumentCategorie $categorie;

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
     * @return string
     */
    public function getLien(): string
    {
        return $this->lien;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string $lien
     */
    public function setLien(string $lien): void
    {
        $this->lien = $lien;
    }

    public function setCreatedAt(): self
    {
        $this->creer = new \DateTime();

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->creer;
    }

    public function setUpdatedAt(): self
    {
        $this->modifier = new \DateTime();

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->modifier;
    }

    /**
     * @return DocumentCategorie
     */
    public function getCategorie(): DocumentCategorie
    {
        return $this->categorie;
    }

    /**
     * @param DocumentCategorie $categorie
     */
    public function setCategorie(DocumentCategorie $categorie): void
    {
        $this->categorie = $categorie;
    }
}