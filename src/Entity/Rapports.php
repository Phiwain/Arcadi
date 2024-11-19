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
    private ?float $poidsNourriture = null; // camelCase pour cohérence

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datePassage = null; // camelCase pour cohérence

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $detail = null;

    #[ORM\ManyToOne(inversedBy: 'rapports')]
    private ?Amnial $Animal = null; // renommé pour cohérence

    #[ORM\Column]
    private ?float $poids = null;

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

    public function getPoidsNourriture(): ?float
    {
        return $this->poidsNourriture;
    }

    public function setPoidsNourriture(float $poidsNourriture): static
    {
        $this->poidsNourriture = $poidsNourriture;

        return $this;
    }

    public function getDatePassage(): ?\DateTimeInterface
    {
        return $this->datePassage;
    }

    public function setDatePassage(\DateTimeInterface $datePassage): static
    {
        $this->datePassage = $datePassage;

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

    public function setAnimal(?Amnial $Animal): self
    {
        $this->Animal = $Animal;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(float $poids): static
    {
        $this->poids = $poids;

        return $this;
    }
}
