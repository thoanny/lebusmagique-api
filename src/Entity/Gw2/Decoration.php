<?php

namespace App\Entity\Gw2;

use App\Entity\Gw2Api\Item;
use App\Repository\Gw2\DecorationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

#[ORM\Entity(repositoryClass: DecorationRepository::class)]
#[ORM\Table(name: 'gw2_decoration')]
#[Vich\Uploadable]
class Decoration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['decorations-categories',  'decoration'])]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'decoration', cascade: ['persist', 'remove'])]
    #[Groups(['decorations-categories', 'decoration'])]
    private ?Item $item = null;

    #[ORM\ManyToOne(inversedBy: 'decorations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['decoration'])]
    private ?DecorationCategory $category = null;

    #[Vich\UploadableField(mapping: 'gw2_decoration_thumbnail', fileNameProperty: 'thumbnail')]
    private ?File $thumbnailFile = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['decoration'])]
    private ?string $thumbnail = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 10)]
    #[Groups(['decorations-categories', 'decoration'])]
    private ?string $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): static
    {
        $this->item = $item;

        return $this;
    }

    public function getCategory(): ?DecorationCategory
    {
        return $this->category;
    }

    public function setCategory(?DecorationCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function setThumbnailFile(?File $thumbnailFile = null): void
    {
        $this->thumbnailFile = $thumbnailFile;

        if (null !== $thumbnailFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getThumbnailFile(): ?File
    {
        return $this->thumbnailFile;
    }

    public function setThumbnail(?string $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

}
