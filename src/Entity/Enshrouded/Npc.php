<?php

namespace App\Entity\Enshrouded;

use App\Repository\Enshrouded\NpcRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: NpcRepository::class)]
#[ORM\Table(name: 'enshrouded_npc')]
#[Vich\Uploadable]
class Npc
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['recipe', 'recipes_sources'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['recipe', 'recipes_sources'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Vich\UploadableField(mapping: 'enshrouded_item_icon', fileNameProperty: 'icon')]
    private ?File $iconFile = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['recipe'])]
    private ?string $icon = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function setIconFile(?File $iconFile = null): void
    {
        $this->iconFile = $iconFile;

        if (null !== $iconFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getIconFile(): ?File
    {
        return $this->iconFile;
    }

    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }
}
