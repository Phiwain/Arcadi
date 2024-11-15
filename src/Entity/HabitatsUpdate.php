<?php

namespace App\Entity;

use App\Repository\HabitatsUpdateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitatsUpdateRepository::class)]
class HabitatsUpdate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'habitatsUpdates')]
    private ?Habitats $habitat = null;

    #[ORM\Column(length: 255)]
    private ?string $avis = null;

    #[ORM\Column(length: 255)]
    private ?string $amelioration = null;
    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHabitat(): ?Habitats
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitats $habitat): static
    {
        $this->habitat = $habitat;

        return $this;
    }

    public function getAvis(): ?string
    {
        return $this->avis;
    }

    public function setAvis(string $avis): static
    {
        $this->avis = $avis;

        return $this;
    }

    public function getAmelioration(): ?string
    {
        return $this->amelioration;
    }

    public function setAmelioration(string $amelioration): static
    {
        $this->amelioration = $amelioration;

        return $this;
    }

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
}
