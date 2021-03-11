<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 * @Vich\Uploadable
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private string $nom;

    /**
     * @ORM\Column(type="string", length=612)
     */
    private string $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $debut;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $fin;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $creer;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $modifier;

    /**
     * @ORM\Column(type="integer")
     */
    private int $nombrePlaces;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private ?string $image = null;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private ?string $vignette = null;

    /**
     * @Vich\UploadableField(mapping="evenement_image", fileNameProperty="image")
     * @var File|null $imageFile
     */
    private ?File $imageFile = null;

    /**
     * @Vich\UploadableField(mapping="evenement_vignette", fileNameProperty="vignette")
     * @var File|null $vignetteFile
     */
    private ?File $vignetteFile = null;

    /**
     * @ORM\ManyToOne(targetEntity=Sport::class, inversedBy="evenement")
     * @ORM\JoinColumn(name="sport", nullable=false, referencedColumnName="id")
     */
    private Sport $sport;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="evenement")
     * @ORM\JoinColumn(name="type", nullable=false, referencedColumnName="id")
     */
    private Type $type;

    /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="evenement" , orphanRemoval=true)
     */
    private Collection $inscription;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $actif;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="evenements")
     */
    private $categorie;

    public function __construct()
    {
        $this->creer = new DateTime();
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
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
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
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDebut(): DateTime
    {
        return $this->debut;
    }

    /**
     * @param DateTime $debut
     */
    public function setDebut(DateTime $debut): self
    {
        $this->debut = $debut;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getFin(): DateTime
    {
        return $this->fin;
    }

    /**
     * @param DateTime $fin
     */
    public function setFin(DateTime $fin): self
    {
        $this->fin = $fin;

        return $this;
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
     * @return int
     */
    public function getNombrePlaces(): int
    {
        return $this->nombrePlaces;
    }

    /**
     * @param int $nombrePlaces
     */
    public function setNombrePlaces(int $nombrePlaces): self
    {
        $this->nombrePlaces = $nombrePlaces;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image = null): self
    {
        $this->image = $image;

        return $this;
    }

    public function getVignette(): ?string
    {
        return $this->vignette;
    }

    public function setVignette(?string $vignette = null): self
    {
        $this->vignette = $vignette;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(File $image): void
    {
        $this->imageFile = $image;

        if ($image) {
            $this->setUpdatedAt();
        }
    }

    public function getVignetteFile(): ?File
    {
        return $this->vignetteFile;
    }

    public function setVignetteFile(File $vignetteFile): void
    {
        $this->vignetteFile = $vignetteFile;

        if ($vignetteFile) {
            $this->setUpdatedAt();
        }
    }

    /**
     * @return Sport
     */
    public function getSport(): Sport
    {
        return $this->sport;
    }

    /**
     * @param Sport $sport
     */
    public function setSport(Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * @return Collection|Inscription[]
     */
    public function getInscription(): ?Collection
    {
        return $this->inscription;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscription->contains($inscription)) {
            $this->inscription[] = $inscription;
            $inscription->setEvenement($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscription->contains($inscription)) {
            $this->inscription->remove($inscription);
            // set the owning side to null (unless already changed)
            if ($inscription->getEvenement() === $this) {
                $inscription->setEvenement(null);
            }
        }

        return $this;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function setType(Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}