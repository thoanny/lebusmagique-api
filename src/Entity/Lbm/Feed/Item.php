<?php

namespace App\Entity\Lbm\Feed;

use App\Repository\Lbm\Feed\ItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ORM\Table(name: 'lbm_feed')]
#[Vich\Uploadable]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $link = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $pubDate = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $guid = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Vich\UploadableField(mapping: 'lbm_feed_image', fileNameProperty: 'image', size: 'imageSize', mimeType: 'imageType')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageType = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getPubDate(): ?\DateTimeImmutable
    {
        return $this->pubDate;
    }

    public function setPubDate(\DateTimeImmutable $pubDate): static
    {
        $this->pubDate = $pubDate;

        return $this;
    }

    public function getGuid(): ?string
    {
        return $this->guid;
    }

    public function setGuid(string $guid): static
    {
        $this->guid = $guid;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function setImageType(?string $imageType): void
    {
        $this->imageType = $imageType;
    }

    public function getImageType(): ?string
    {
        return $this->imageType;
    }
}
