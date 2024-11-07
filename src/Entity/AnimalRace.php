<?php

namespace App\Entity;

use App\Repository\AnimalRaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRaceRepository::class)]
class AnimalRace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Amnial>
     */
    #[ORM\OneToMany(targetEntity: Amnial::class, mappedBy: 'race')]
    private Collection $amnials;

    public function __construct()
    {
        $this->amnials = new ArrayCollection();
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

    public function __toString(){
        return $this->nom;
    }
    /**
     * @return Collection<int, Amnial>
     */
    public function getAmnials(): Collection
    {
        return $this->amnials;
    }

    public function addAmnial(Amnial $amnial): static
    {
        if (!$this->amnials->contains($amnial)) {
            $this->amnials->add($amnial);
            $amnial->setRace($this);
        }

        return $this;
    }

    public function removeAmnial(Amnial $amnial): static
    {
        if ($this->amnials->removeElement($amnial)) {
            // set the owning side to null (unless already changed)
            if ($amnial->getRace() === $this) {
                $amnial->setRace(null);
            }
        }

        return $this;
    }
}
