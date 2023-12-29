<?php

namespace App\Entity\Gw2\Fish;

use App\Entity\Gw2Api\Item;
use App\Repository\Gw2\Fish\DailyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DailyRepository::class)]
#[ORM\Table(name: 'gw2_fish_daily')]
class Daily
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $day = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('fish')]
    private ?Fish $fish = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?\DateTimeImmutable
    {
        return $this->day;
    }

    public function setDay(\DateTimeImmutable $day): static
    {
        $this->day = $day;

        return $this;
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

    #[Groups('fish')]
    public function getDate() {
        return $this->day->format('Y-m-d');
    }
}
