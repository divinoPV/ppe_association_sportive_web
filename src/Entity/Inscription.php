<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 */
class Inscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreer(): ?\DateTimeInterface
    {
        return $this->creer;
    }

    public function setCreer(\DateTimeInterface $creer): self
    {
        $this->creer = $creer;

        return $this;
    }
}
