<?php

namespace App\Entity\Genshin\Map;

use App\Repository\Genshin\Map\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
#[ORM\Table(name: 'genshin_map_section')]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Group::class, orphanRemoval: true)]
    private Collection $markersGroups;

    #[ORM\Column(nullable: true)]
    private ?int $position = null;

    #[ORM\ManyToOne(inversedBy: 'sections')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Map $map = null;

    public function __construct()
    {
        $this->markersGroups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getMarkersGroups(): Collection
    {
        return $this->markersGroups;
    }

    public function addMarkersGroup(Group $markersGroup): self
    {
        if (!$this->markersGroups->contains($markersGroup)) {
            $this->markersGroups->add($markersGroup);
            $markersGroup->setSection($this);
        }

        return $this;
    }

    public function removeMarkersGroup(Group $markersGroup): self
    {
        if ($this->markersGroups->removeElement($markersGroup)) {
            // set the owning side to null (unless already changed)
            if ($markersGroup->getSection() === $this) {
                $markersGroup->setSection(null);
            }
        }

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getMap(): ?Map
    {
        return $this->map;
    }

    public function setMap(?Map $map): self
    {
        $this->map = $map;

        return $this;
    }
}
