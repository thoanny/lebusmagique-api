<?php

namespace App\Entity\Gw2\Fish;

use App\Entity\Gw2Api\Item;
use App\Repository\Gw2\Fish\BaitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BaitRepository::class)]
#[ORM\Table(name: 'gw2_fish_bait')]
class Bait implements \Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'bait', cascade: ['persist', 'remove'])]
    #[Groups('fish')]
    private ?Item $item = null;

    #[ORM\Column(length: 25, nullable: true)]
    #[Groups('fish')]
    private ?string $power = null;

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

    public function getPower(): ?string
    {
        return $this->power;
    }

    public function setPower(?string $power): static
    {
        $this->power = $power;

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->item->getName();
    }
}
