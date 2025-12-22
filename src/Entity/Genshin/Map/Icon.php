<?php

namespace App\Entity\Genshin\Map;

use App\Repository\Genshin\Map\IconRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

#[ORM\Entity(repositoryClass: IconRepository::class)]
#[ORM\Table(name: 'genshin_map_icon')]
#[Vich\Uploadable]
class Icon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Vich\UploadableField(mapping: 'genshin_map_icon', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 25)]
    private ?string $iconSize = null;

    #[ORM\Column(length: 25)]
    private ?string $iconAnchor = null;

    #[ORM\Column(length: 25)]
    private ?string $popupAnchor = null;

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

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getIconSize(): ?string
    {
        return $this->iconSize;
    }

    public function setIconSize(string $iconSize): self
    {
        $this->iconSize = $iconSize;

        return $this;
    }

    public function getIconAnchor(): ?string
    {
        return $this->iconAnchor;
    }

    public function setIconAnchor(string $iconAnchor): self
    {
        $this->iconAnchor = $iconAnchor;

        return $this;
    }

    public function getPopupAnchor(): ?string
    {
        return $this->popupAnchor;
    }

    public function setPopupAnchor(string $popupAnchor): self
    {
        $this->popupAnchor = $popupAnchor;

        return $this;
    }
}
