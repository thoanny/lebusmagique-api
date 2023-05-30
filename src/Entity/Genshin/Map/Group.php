<?php

namespace App\Entity\Genshin\Map;

use App\Repository\Genshin\Map\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: 'genshin_map_group')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $format = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $guide = null;

    #[ORM\Column]
    private ?bool $checkbox = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\ManyToOne(inversedBy: 'markersGroups')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Section $section = null;

    #[ORM\Column(nullable: true)]
    private ?int $position = null;

    #[ORM\OneToMany(mappedBy: 'markerGroup', targetEntity: Marker::class, orphanRemoval: true)]
    private Collection $markers;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Icon $icon = null;

    #[ORM\Column(nullable: true)]
    private ?int $x = null;

    #[ORM\Column(nullable: true)]
    private ?int $y = null;

    #[ORM\Column(nullable: true)]
    private ?int $z = null;

    public function __construct()
    {
        $this->markers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(?string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getGuide(): ?string
    {
        return $this->guide;
    }

    public function setGuide(?string $guide): self
    {
        $this->guide = $guide;

        return $this;
    }

    public function isCheckbox(): ?bool
    {
        return $this->checkbox;
    }

    public function setCheckbox(bool $checkbox): self
    {
        $this->checkbox = $checkbox;

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

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

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

    /**
     * @return Collection<int, Marker>
     */
    public function getMarkers(): Collection
    {
        return $this->markers;
    }

    public function addMarker(Marker $marker): self
    {
        if (!$this->markers->contains($marker)) {
            $this->markers->add($marker);
            $marker->setMarkerGroup($this);
        }

        return $this;
    }

    public function removeMarker(Marker $marker): self
    {
        if ($this->markers->removeElement($marker)) {
            // set the owning side to null (unless already changed)
            if ($marker->getMarkerGroup() === $this) {
                $marker->setMarkerGroup(null);
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

    public function getX(): ?int
    {
        return $this->x;
    }

    public function setX(int $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function setY(?int $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function getZ(): ?int
    {
        return $this->z;
    }

    public function setZ(?int $z): self
    {
        $this->z = $z;

        return $this;
    }
}
