<?php

namespace App\Entity;

use App\Repository\OuverturesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OuverturesRepository::class)]
class Ouvertures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\Column]
    private ?float $OpenMorning = null;

    #[ORM\Column(nullable: true)]
    private ?float $ClosedMorning = null;

    #[ORM\Column(nullable: true)]
    private ?float $OpenEvening = null;

    #[ORM\Column]
    private ?float $ClosedEvening = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getOpenMorning(): ?float
    {
        return $this->OpenMorning;
    }

    public function setOpenMorning(float $OpenMorning): static
    {
        $this->OpenMorning = $OpenMorning;

        return $this;
    }

    public function getClosedMorning(): ?float
    {
        return $this->ClosedMorning;
    }

    public function setClosedMorning(?float $ClosedMorning): static
    {
        $this->ClosedMorning = $ClosedMorning;

        return $this;
    }

    public function getOpenEvening(): ?float
    {
        return $this->OpenEvening;
    }

    public function setOpenEvening(?float $OpenEvening): static
    {
        $this->OpenEvening = $OpenEvening;

        return $this;
    }

    public function getClosedEvening(): ?float
    {
        return $this->ClosedEvening;
    }

    public function setClosedEvening(float $ClosedEvening): static
    {
        $this->ClosedEvening = $ClosedEvening;

        return $this;
    }

    public function getFormattedOpeningHours(): string
    {
        return sprintf(
            '%s ouvert de %.2f à %.2f et de %.2f à %.2f',
            $this->getDay(),
            $this->getOpenMorning(),
            $this->getClosedMorning() ?? 0.00,
            $this->getOpenEvening() ?? 0.00,
            $this->getClosedEvening()
        );
    }
}
