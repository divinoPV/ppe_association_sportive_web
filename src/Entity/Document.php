<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=256)
     * @Assert\NotBlank()
     */
    private string $nom;

    /**
     * @ORM\Column(type="string", length=256)
     * @Assert\NotBlank()
     */
    private string $lien;

    /**
     * @ORM\Column(type="string", length=256)
     * @Assert\NotBlank()
     */
    private string $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $creer;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $modifier;

    /**
     * @ORM\ManyToOne(targetEntity=DocumentCategorie::class, inversedBy="document")
     * @ORM\JoinColumn(name="categorie", nullable=false, referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private DocumentCategorie $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="documents")
     * @ORM\JoinColumn(name="evenement", nullable=false, referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private Evenement $evenement;

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
     * @return Document
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
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
     * @return Document
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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
        $this->creer = new DateTime();

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->creer;
    }

    public function setUpdatedAt(): self
    {
        $this->modifier = new DateTime();

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
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
     * @return Document
     */
    public function setCategorie(DocumentCategorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }

    public function getEvenement(): Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(Evenement $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }
}