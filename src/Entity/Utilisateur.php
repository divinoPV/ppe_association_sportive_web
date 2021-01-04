<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

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
    private ?string $plainPassword = null;

    /**
     * @var string The hashed plainPassword
     * @ORM\Column(type="string")
     */
    private string $password;

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

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}