<?php

namespace App\Entity\Gw2\Fish;

use App\Repository\Gw2\Fish\FishHoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FishHoleRepository::class)]
#[ORM\Table(name: 'gw2_fish_fish_hole')]
class FishHole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'fishHoles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fish $fish = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('fish')]
    private ?Hole $hole = null;

    #[ORM\Column(length: 5, nullable: true)]
    #[Groups('fish')]
    private ?string $frequency = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFish(): ?Fish
    {
        return $this->fish;
    }

    public function setFish(?Fish $fish): static
    {
        $this->fish = $fish;

        return $this;
    }

    public function getHole(): ?Hole
    {
        return $this->hole;
    }

    public function setHole(?Hole $hole): static
    {
        $this->hole = $hole;
        return $this;
    }

    public function getFrequency(): ?string
    {
        return $this->frequency;
    }

    public function setFrequency(?string $frequency): static
    {
        $this->frequency = $frequency;

        return $this;
    }
}
