<?php

namespace App\Entity\Gw2\Fish;

use App\Repository\Gw2\Fish\MapRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MapRepository::class)]
#[ORM\Table(name: 'gw2_fish_map')]
class Map
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $mapId = null;

    #[ORM\ManyToOne(inversedBy: 'maps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Achievement $fishAchievement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMapId(): ?int
    {
        return $this->mapId;
    }

    public function setMapId(int $mapId): self
    {
        $this->mapId = $mapId;

        return $this;
    }

    public function getFishAchievement(): ?Achievement
    {
        return $this->fishAchievement;
    }

    public function setFishAchievement(?Achievement $fishAchievement): self
    {
        $this->fishAchievement = $fishAchievement;

        return $this;
    }
}
