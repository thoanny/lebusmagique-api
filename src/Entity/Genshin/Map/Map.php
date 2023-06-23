<?php

namespace App\Entity\Genshin\Map;

use App\Repository\Genshin\Map\MapRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: MapRepository::class)]
#[ORM\Table(name: 'genshin_map')]
class Map
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\OneToMany(mappedBy: 'map', targetEntity: Section::class, orphanRemoval: true)]
    private Collection $sections;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Icon $icon = null;

    #[ORM\Column(length: 255)]
    private ?string $bounds = null;

    #[ORM\Column(length: 25)]
    private ?string $center = null;

    #[ORM\Column]
    private ?int $zoom = null;

    #[ORM\Column(length: 255)]
    private ?string $tiles = null;

    #[ORM\Column]
    private ?int $minZoom = null;

    #[ORM\Column]
    private ?int $maxZoom = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column(length: 128, unique: true)]
    #[Gedmo\Slug(fields: ['name'])]
    private $slug;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
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
     * @return Collection<int, Section>
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): self
    {
        if (!$this->sections->contains($section)) {
            $this->sections->add($section);
            $section->setMap($this);
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        if ($this->sections->removeElement($section)) {
            // set the owning side to null (unless already changed)
            if ($section->getMap() === $this) {
                $section->setMap(null);
            }
        }

        return $this;
    }

    public function getIcon(): ?Icon
    {
        return $this->icon;
    }

    public function setIcon(?Icon $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getBounds(): ?string
    {
        return $this->bounds;
    }

    public function setBounds(string $bounds): self
    {
        $this->bounds = $bounds;

        return $this;
    }

    public function getCenter(): ?string
    {
        return $this->center;
    }

    public function setCenter(string $center): self
    {
        $this->center = $center;

        return $this;
    }

    public function getZoom(): ?int
    {
        return $this->zoom;
    }

    public function setZoom(int $zoom): self
    {
        $this->zoom = $zoom;

        return $this;
    }

    public function getTiles(): ?string
    {
        return $this->tiles;
    }

    public function setTiles(string $tiles): self
    {
        $this->tiles = $tiles;

        return $this;
    }

    public function getMinZoom(): ?int
    {
        return $this->minZoom;
    }

    public function setMinZoom(int $minZoom): self
    {
        $this->minZoom = $minZoom;

        return $this;
    }

    public function getMaxZoom(): ?int
    {
        return $this->maxZoom;
    }

    public function setMaxZoom(int $maxZoom): self
    {
        $this->maxZoom = $maxZoom;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function __toString() {
        return $this->name;
    }
}
