<?php

namespace App\Entity\Enshrouded;

use App\Repository\Enshrouded\MapCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: MapCategoryRepository::class)]
#[ORM\Table(name: 'enshrouded_map_category')]
#[Vich\Uploadable]
class MapCategory
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

    #[ORM\Column(nullable: true)]
    #[Groups('api')]
    private ?bool $visible = null;

    #[ORM\Column(nullable: true)]
    #[Groups('api')]
    private ?bool $checked = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?MapIcon $icon = null;

    #[ORM\ManyToOne]
    private ?MapIcon $iconChecked = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: MapMarker::class, orphanRemoval: true)]
    private Collection $mapMarkers;

    #[Vich\UploadableField(mapping: 'enshrouded_map_icon', fileNameProperty: 'iconMenu')]
    private ?File $iconMenuFile = null;

    #[ORM\Column(nullable: true)]
    #[Groups('api')]
    private ?string $iconMenu = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->mapMarkers = new ArrayCollection();
    }

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

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(?bool $visible): static
    {
        $this->visible = $visible;

        return $this;
    }

    public function isChecked(): ?bool
    {
        return $this->checked;
    }

    public function setChecked(?bool $checked): static
    {
        $this->checked = $checked;

        return $this;
    }

    public function getIcon(): ?MapIcon
    {
        return $this->icon;
    }

    #[Groups('api')]
    public function getIconUrl(): ?string
    {
        return ($this->icon) ? '/uploads/api/enshrouded/map/icons/' . $this->icon->getIcon() : null;
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

    #[Groups('api')]
    public function getIconCheckedUrl(): ?string
    {
        return ($this->iconChecked) ? '/uploads/api/enshrouded/map/icons/' . $this->iconChecked->getIcon() : null;
    }

    public function setIconChecked(?MapIcon $iconChecked): static
    {
        $this->iconChecked = $iconChecked;

        return $this;
    }

    public function setIconMenuFile(?File $iconMenuFile = null): void
    {
        $this->iconMenuFile = $iconMenuFile;

        if (null !== $iconMenuFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getIconMenuFile(): ?File
    {
        return $this->iconMenuFile;
    }

    public function setIconMenu(?string $iconMenu): void
    {
        $this->iconMenu = $iconMenu;
    }

    public function getIconMenu(): ?string
    {
        return $this->iconMenu;
    }

    #[Groups('api')]
    public function getIconMenuUrl(): ?string
    {
        return ($this->iconMenu) ? "/uploads/api/enshrouded/map/icons/$this->iconMenu" : null;
    }

    /**
     * @return Collection<int, MapMarker>
     */
    public function getMapMarkers(): Collection
    {
        return $this->mapMarkers;
    }

    #[Groups('api')]
    public function getMarkers(): Collection
    {
        return $this->mapMarkers;
    }

    public function addMapMarker(MapMarker $mapMarker): static
    {
        if (!$this->mapMarkers->contains($mapMarker)) {
            $this->mapMarkers->add($mapMarker);
            $mapMarker->setCategory($this);
        }

        return $this;
    }

    public function removeMapMarker(MapMarker $mapMarker): static
    {
        if ($this->mapMarkers->removeElement($mapMarker)) {
            // set the owning side to null (unless already changed)
            if ($mapMarker->getCategory() === $this) {
                $mapMarker->setCategory(null);
            }
        }

        return $this;
    }
}
