<?php

namespace App\Entity;

use App\Repository\AmnialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AmnialRepository::class)]
class Amnial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'amnials')]
    private ?AnimalRace $race = null;

    #[ORM\ManyToOne(inversedBy: 'amnials')]
    private ?Habitats $habitat = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration = null;

    /**
     * @var Collection<int, Rapports>
     */
    #[ORM\OneToMany(targetEntity: Rapports::class, mappedBy: 'Animal')]
    private Collection $rapports;

    /**
     * @var Collection<int, AnimalUpdate>
     */
    #[ORM\OneToMany(targetEntity: AnimalUpdate::class, mappedBy: 'Animal')]
    private Collection $animalUpdates;

    #[ORM\Column]
    private ?float $Poids = null;

    public function __construct()
    {
        $this->rapports = new ArrayCollection();
        $this->animalUpdates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRace(): ?AnimalRace
    {
        return $this->race;
    }

    public function setRace(?AnimalRace $race): static
    {
        $this->race = $race;

        return $this;
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

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): static
    {
        $this->illustration = $illustration;

        return $this;
    }
    public function __toString(){
        return $this->nom;
    }
    private $views = 0;

    public function getViews()
    {
        return $this->views;
    }

    public function setViews($views)
    {
        $this->views = $views;
    }

    /**
     * @return Collection<int, Rapports>
     */
    public function getRapports(): Collection
    {
        return $this->rapports;
    }

    public function addRapport(Rapports $rapport): static
    {
        if (!$this->rapports->contains($rapport)) {
            $this->rapports->add($rapport);
            $rapport->setAnimal($this);
        }

        return $this;
    }

    public function removeRapport(Rapports $rapport): static
    {
        if ($this->rapports->removeElement($rapport)) {
            // set the owning side to null (unless already changed)
            if ($rapport->getAnimal() === $this) {
                $rapport->setAnimal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AnimalUpdate>
     */
    public function getAnimalUpdates(): Collection
    {
        return $this->animalUpdates;
    }

    public function addAnimalUpdate(AnimalUpdate $animalUpdate): static
    {
        if (!$this->animalUpdates->contains($animalUpdate)) {
            $this->animalUpdates->add($animalUpdate);
            $animalUpdate->setAnimal($this);
        }

        return $this;
    }

    public function removeAnimalUpdate(AnimalUpdate $animalUpdate): static
    {
        if ($this->animalUpdates->removeElement($animalUpdate)) {
            // set the owning side to null (unless already changed)
            if ($animalUpdate->getAnimal() === $this) {
                $animalUpdate->setAnimal(null);
            }
        }

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->Poids;
    }

    public function setPoids(float $Poids): static
    {
        $this->Poids = $Poids;

        return $this;
    }
}
