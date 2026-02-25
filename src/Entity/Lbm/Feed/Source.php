<?php

namespace App\Entity\Lbm\Feed;

use App\Repository\Lbm\Feed\SourceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SourceRepository::class)]
#[ORM\Table(name: 'lbm_feed_source')]
class Source
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['source'])]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    #[Groups(['source'])]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    #[Groups(['source'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['source'])]
    private ?string $uid = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['source'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?bool $active = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }
}
