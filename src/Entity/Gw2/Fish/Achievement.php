<?php

namespace App\Entity\Gw2\Fish;

use App\Entity\Gw2Api\Item;
use App\Repository\Gw2\Fish\AchievementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AchievementRepository::class)]
#[ORM\Table(name: 'gw2_fish_achievement')]
class Achievement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('fish')]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    #[Groups('fish')]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups('fish')]
    private ?int $achievementId = null;

    #[ORM\Column]
    #[Groups('fish')]
    private ?int $achievementRepeatId = null;

    #[ORM\OneToMany(mappedBy: 'fishAchievement', targetEntity: Map::class)]
    private Collection $maps;

    public function __construct()
    {
        $this->maps = new ArrayCollection();
    }

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

    public function getAchievementId(): ?int
    {
        return $this->achievementId;
    }

    public function setAchievementId(int $achievementId): self
    {
        $this->achievementId = $achievementId;

        return $this;
    }

    public function getAchievementRepeatId(): ?int
    {
        return $this->achievementRepeatId;
    }

    public function setAchievementRepeatId(int $achievementRepeatId): self
    {
        $this->achievementRepeatId = $achievementRepeatId;

        return $this;
    }

    /**
     * @return Collection<int, Map>
     */
    public function getMaps(): Collection
    {
        return $this->maps;
    }

    public function addMap(Map $map): self
    {
        if (!$this->maps->contains($map)) {
            $this->maps->add($map);
            $map->setFishAchievement($this);
        }

        return $this;
    }

    public function removeMap(Map $map): self
    {
        if ($this->maps->removeElement($map)) {
            // set the owning side to null (unless already changed)
            if ($map->getFishAchievement() === $this) {
                $map->setFishAchievement(null);
            }
        }

        return $this;
    }
}
