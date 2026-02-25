<?php

namespace App\Entity\Lbm\Feed;

use App\Repository\Lbm\Feed\ItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ORM\Table(name: 'lbm_feed_item')]
#[Vich\Uploadable]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['feed'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['feed'])]
    private ?string $title = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['feed'])]
    private ?string $link = null;

    #[ORM\Column]
    #[Groups(['feed'])]
    private ?\DateTimeImmutable $pubDate = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $guid = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['feed'])]
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

    #[Groups(['feed'])]
    #[ORM\Column(length: 25, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $externalImageUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['feed'])]
    private ?string $username = null;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getExternalImageUrl(): ?string
    {
        return $this->externalImageUrl;
    }

    public function setExternalImageUrl(?string $externalImageUrl): static
    {
        $this->externalImageUrl = $externalImageUrl;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;

        return $this;
    }

    #[Groups(['feed'])]
    public function getImageUrl(): ?string
    {
        if($this->image){
            return "https://api.lebusmagique.fr/uploads/lbm/feeds/{$this->image}";
        } elseif ($this->externalImageUrl) {
            return $this->externalImageUrl;
        }

        return null;
    }
}
