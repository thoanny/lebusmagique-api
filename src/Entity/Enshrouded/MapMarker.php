<?php

namespace App\Entity\Enshrouded;

use App\Repository\Enshrouded\MapMarkerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

#[ORM\Entity(repositoryClass: MapMarkerRepository::class)]
#[ORM\Table(name: 'enshrouded_map_marker')]
#[Vich\Uploadable]
class MapMarker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, unique: true)]
    #[Groups('api')]
    private ?string $uid = null;

    #[ORM\Column(length: 255)]
    #[Groups('api')]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups('api')]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups('api')]
    private ?float $posX = null;

    #[ORM\Column]
    #[Groups('api')]
    private ?float $posY = null;

    #[Vich\UploadableField(mapping: 'enshrouded_map_marker_image', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 25, nullable: true)]
    #[Groups('api')]
    private ?string $video = null;

    #[ORM\ManyToOne]
    private ?MapIcon $icon = null;

    #[ORM\ManyToOne]
    private ?MapIcon $iconChecked = null;

    #[ORM\ManyToOne(inversedBy: 'mapMarkers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MapCategory $category = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(string $uid): static
    {
        $this->uid = $uid;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPosX(): ?float
    {
        return $this->posX;
    }

    public function setPosX(float $posX): static
    {
        $this->posX = $posX;

        return $this;
    }

    public function getPosY(): ?float
    {
        return $this->posY;
    }

    public function setPosY(float $posY): static
    {
        $this->posY = $posY;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): static
    {
        $this->video = $video;

        return $this;
    }

    public function getIcon(): ?MapIcon
    {
        return $this->icon;
    }

    public function setIcon(?MapIcon $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIconChecked(): ?MapIcon
    {
        return $this->iconChecked;
    }

    public function setIconChecked(?MapIcon $iconChecked): static
    {
        $this->iconChecked = $iconChecked;

        return $this;
    }

    public function getCategory(): ?MapCategory
    {
        return $this->category;
    }

    public function setCategory(?MapCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    #[Groups('api')]
    public function getImageUrl(): ?string
    {
        return ($this->image) ? '/uploads/api/enshrouded/map/images/' . $this->image : null;
    }

    #[Groups('api')]
    public function getIconUrl(): ?string
    {
        return ($this->icon) ? '/uploads/api/enshrouded/map/icons/' . $this->icon->getIcon() : null;
    }

    #[Groups('api')]
    public function getIconCheckedUrl(): ?string
    {
        return ($this->iconChecked) ? '/uploads/api/enshrouded/map/icons/' . $this->iconChecked->getIcon() : null;
    }
}
