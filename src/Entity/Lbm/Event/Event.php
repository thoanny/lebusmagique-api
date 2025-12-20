<?php

namespace App\Entity\Lbm\Event;

use App\Repository\Lbm\Event\EventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\Table(name: 'lbm_event')]
#[Vich\Uploadable]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Groups(['api'])]
    private ?string $uid = null;

    #[ORM\Column]
    #[Groups(['api'])]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column]
    #[Groups(['api'])]
    private ?\DateTimeImmutable $endAt = null;

    #[Vich\UploadableField(mapping: 'lbm_event_image', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['api'])]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['api'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private array $data = [];

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

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

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

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    #[Groups(['api'])]
    public function getTitle(): string
    {
        return $this->data['title'] ?? 'Sans titre';
    }

    #[Groups(['api'])]
    public function getType(): string
    {
        return $this->data['type'] ?? 'NONE';
    }

    #[Groups(['api'])]
    public function getDescription(): string
    {
        return $this->data['description'] ?? '';
    }

    #[Groups(['api'])]
    public function getLeaderGw2(): string
    {
        return $this->data['leaderGW2'] ?? '';
    }

    #[Groups(['api'])]
    public function getSeats(): string
    {
        if($this->data['maxSubscribers'] > 0) {
            return "{$this->data['subscriberCount']}/{$this->data['maxSubscribers']}";
        } else {
            return $this->data['subscriberCount'] ?? 'Ø';
        }

    }
}
