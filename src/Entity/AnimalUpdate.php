<?php

namespace App\Entity;

use App\Repository\AnimalUpdateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalUpdateRepository::class)]
class AnimalUpdate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $Time = null;

    #[ORM\Column(nullable: true)]
    private ?float $QuantiteNourriture = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Nourriture = null;

    #[ORM\ManyToOne(inversedBy: 'animalUpdates')]
    private ?Amnial $Animal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->Time;
    }

    public function setTime(\DateTimeInterface $Time): static
    {
        $this->Time = $Time;

        return $this;
    }

    public function getQuantiteNourriture(): ?float
    {
        return $this->QuantiteNourriture;
    }

    public function setQuantiteNourriture(?float $QuantiteNourriture): static
    {
        $this->QuantiteNourriture = $QuantiteNourriture;

        return $this;
    }

    public function getNourriture(): ?string
    {
        return $this->Nourriture;
    }

    public function setNourriture(?string $Nourriture): static
    {
        $this->Nourriture = $Nourriture;

        return $this;
    }

    public function getAnimal(): ?Amnial
    {
        return $this->Animal;
    }

    public function setAnimal(?Amnial $Animal): static
    {
        $this->Animal = $Animal;

        return $this;
    }
}
