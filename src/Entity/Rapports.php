<?php

namespace App\Entity;

use App\Repository\RapportsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportsRepository::class)]
class Rapports
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\Column(length: 255)]
    private ?string $nourriture = null;

    #[ORM\Column]
    private ?float $Poidsnourriture = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datepassage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $detail = null;

    #[ORM\ManyToOne(inversedBy: 'rapports')]
    private ?Amnial $Animal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getNourriture(): ?string
    {
        return $this->nourriture;
    }

    public function setNourriture(string $nourriture): static
    {
        $this->nourriture = $nourriture;

        return $this;
    }

    public function getPoidsnourriture(): ?float
    {
        return $this->Poidsnourriture;
    }

    public function setPoidsnourriture(float $Poidsnourriture): static
    {
        $this->Poidsnourriture = $Poidsnourriture;

        return $this;
    }

    public function getDatepassage(): ?\DateTimeInterface
    {
        return $this->datepassage;
    }

    public function setDatepassage(\DateTimeInterface $datepassage): static
    {
        $this->datepassage = $datepassage;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(?string $detail): static
    {
        $this->detail = $detail;

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
