<?php

namespace App\Entity\Gw2\Fish;

use App\Repository\Gw2\Fish\FishTimeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FishTimeRepository::class)]
#[ORM\Table(name: 'gw2_fish_fish_time')]
class FishTime
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'fishTimes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fish $fish = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('fish')]
    private ?Time $time = null;

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

    public function getTime(): ?Time
    {
        return $this->time;
    }

    public function setTime(?Time $time): static
    {
        $this->time = $time;

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
