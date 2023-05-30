<?php

namespace App\Entity\Genshin\Map;

use App\Repository\Genshin\Map\MarkerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarkerRepository::class)]
#[ORM\Table(name: 'genshin_map_marker')]
class Marker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $format = null;

    #[ORM\ManyToOne(inversedBy: 'markers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Group $markerGroup = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $video = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $guide = null;

    #[ORM\Column(length: 25)]
    private ?string $x = null;

    #[ORM\Column(length: 25)]
    private ?string $y = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\ManyToOne]
    private ?Icon $icon = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getMarkerGroup(): ?Group
    {
        return $this->markerGroup;
    }

    public function setMarkerGroup(?Group $markerGroup): self
    {
        $this->markerGroup = $markerGroup;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

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

    public function getX(): ?string
    {
        return $this->x;
    }

    public function setX(string $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?string
    {
        return $this->y;
    }

    public function setY(string $y): self
    {
        $this->y = $y;

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

    public function getIcon(): ?Icon
    {
        return $this->icon;
    }

    public function setIcon(?Icon $icon): self
    {
        $this->icon = $icon;

        return $this;
    }
}
