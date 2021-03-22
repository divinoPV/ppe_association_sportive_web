<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     message="L'email indiqué est déjà utiliser"
 * )
 */
class User implements UserInterface, Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(
     *     message = "Veuillez saisir une valeur !"
     * )
     * @Assert\Length(
     *     min=10,
     *     minMessage = "Votre email doit comporter au minimum {{ limit }} caractères !",
     *     max=180,
     *     maxMessage = "Votre email ne doit pas dépasser {{ limit }} caractères !"
     * )
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas valide !"
     * )
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles;

    /**
     * @var string The hashed plainPassword
     * @ORM\Column(name="mdp", type="string")
     */
    private string $password;

    /**
     * @var string|null
     * @Assert\NotBlank(
     *     message = "Veuillez saisir une valeur !"
     * )
     * @Assert\Regex(
     *     pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[.\-+!*$@%_])([.\-+!*$@%_\w]{8,32})$/",
     *     message = "Votre mot de passe doit contenir un caractère spécial, une lettre minuscule,
     *     une majuscule, 8 caractères et 32 caractères maximum et un chiffre."
     * )
     */
    private ?string $plainPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(
     *     message = "Veuillez sélectionner une valeur !"
     * )
     */
    private ?string $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(
     *     message = "Veuillez sélectionner une valeur !"
     * )
     */
    private ?string $prenom;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $forgottenPassword;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\NotBlank(
     *     message = "Veuillez selectionner votre date de naissance !"
     * )
     */
    private ?DateTime $naissance;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $creerA;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $modifierA;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="user")
     * @ORM\JoinColumn(name="categorie", referencedColumnName="id", onDelete="SET NULL")
     * @Assert\NotBlank(
     *     message = "Veuillez sélectionner une valeur !"
     * )
     */
    private Categorie $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="user")
     */
    private Collection $inscription;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     * @return User
     */
    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNaissance(): ?DateTimeInterface
    {
        return $this->naissance;
    }

    public function setNaissance(?DateTimeInterface $naissance): self
    {
        $this->naissance = $naissance;

        return $this;
    }

    public function getCreer(): ?DateTimeInterface
    {
        return $this->creerA;
    }

    public function setCreer(?DateTimeInterface $creerA): self
    {
        $this->creerA = $creerA;

        return $this;
    }

    public function getModifier(): ?DateTimeInterface
    {
        return $this->modifierA;
    }

    public function setModifier(?DateTimeInterface $modifierA): self
    {
        $this->modifierA = $modifierA;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = "ROLE_USER";

        return array_unique($roles);
    }

    /**
     * @param string $roles
     * @return User
     */
    public function setRoles(string $roles): self
    {
        $this->roles[] = $roles;

        return $this;
    }

    public function addRoles(): self
    {
        $this->roles[] = "ROLE_USER";

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getForgottenPassword(): ?bool
    {
        return $this->forgottenPassword;
    }

    /**
     * @param bool|null $forgottenPassword
     * @return User
     */
    public function setForgottenPassword(?bool $forgottenPassword): self
    {
        $this->forgottenPassword = $forgottenPassword;

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
            $inscription->setUser($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscription->contains($inscription)) {
            $this->inscription->remove($inscription);
            // set the owning side to null (unless already changed)
            if ($inscription->getUser() === $this) {
                $inscription->setUser(null);
            }
        }

        return $this;
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password) = unserialize($serialized, ['allowed_classes' => false]);
    }
}
