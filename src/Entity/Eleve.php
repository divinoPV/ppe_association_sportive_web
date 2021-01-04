<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EleveRepository::class)
 */
class Eleve
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
    private string $prenom;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $naissance;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $creer;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $modifier;

    /**
     * @ORM\ManyToOne(targetEntity=Sport::class)
     * @ORM\JoinColumn(name="categorie", nullable=false, referencedColumnName="id")
     */
    private Categorie $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="eleve")
     */
    private Collection $inscription;

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
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return \DateTime
     */
    public function getNaissance(): \DateTime
    {
        return $this->naissance;
    }

    /**
     * @param \DateTime $naissance
     */
    public function setNaissance(\DateTime $naissance): void
    {
        $this->naissance = $naissance;
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
     * @return Categorie
     */
    public function getCategorie(): Categorie
    {
        return $this->categorie;
    }

    /**
     * @param Categorie $categorie
     */
    public function setCategorie(Categorie $categorie): void
    {
        $this->categorie = $categorie;
    }

    /**
     * @return Collection|null
     */
    public function getInscription(): ?Collection
    {
        return $this->inscription;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscription->contains($inscription)) {
            $this->inscription[] = $inscription;
            $inscription->setEleve($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscription->contains($inscription)) {
            $this->inscription->remove($inscription);
            // set the owning side to null (unless already changed)
            if ($inscription->getEleve() === $this) {
                $inscription->setEleve(null);
            }
        }

        return $this;
    }
}