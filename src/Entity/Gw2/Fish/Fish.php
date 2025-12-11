<?php

namespace App\Entity\Gw2\Fish;

use App\Entity\Gw2Api\Item;
use App\Repository\Gw2\Fish\FishRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FishRepository::class)]
#[ORM\Table(name: 'gw2_fish')]
class Fish implements \Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55, nullable: true)]
    #[Groups('fish')]
    private ?string $power = null;

    #[ORM\Column(length: 25, nullable: true)]
    #[Groups('fish')]
    private ?string $specialization = null;

    #[ORM\Column(nullable: true)]
    #[Groups('fish')]
    private ?bool $strangeDiet = null;

    #[ORM\Column(nullable: true)]
    #[Groups('fish')]
    private ?bool $baitAny = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups('fish')]
    private ?Achievement $achievement = null;

    #[ORM\ManyToOne]
    #[Groups('fish')]
    private ?Bait $bait = null;

    #[ORM\OneToMany(mappedBy: 'fish', targetEntity: FishHole::class, cascade: ['persist'], orphanRemoval: true)]
    #[Groups('fish')]
    private Collection $fishHoles;

    #[ORM\OneToMany(mappedBy: 'fish', targetEntity: FishTime::class, cascade: ['persist'], orphanRemoval: true)]
    #[Groups('fish')]
    private Collection $fishTimes;

    #[ORM\OneToOne(inversedBy: 'fish', cascade: ['persist', 'remove'])]
    #[Groups('fish')]
    private ?Item $item = null;

    protected ?String $status = null;

    public function __construct()
    {
        $this->fishHoles = new ArrayCollection();
        $this->fishTimes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPower(): ?string
    {
        return $this->power;
    }

    public function setPower(string $power): static
    {
        $this->power = $power;

        return $this;
    }

    public function getSpecialization(): ?string
    {
        return $this->specialization;
    }

    public function setSpecialization(?string $specialization): static
    {
        $this->specialization = $specialization;

        return $this;
    }

    public function isStrangeDiet(): ?bool
    {
        return $this->strangeDiet;
    }

    public function setStrangeDiet(?bool $strangeDiet): static
    {
        $this->strangeDiet = $strangeDiet;

        return $this;
    }

    public function isBaitAny(): ?bool
    {
        return $this->baitAny;
    }

    public function setBaitAny(?bool $baitAny): static
    {
        $this->baitAny = $baitAny;

        return $this;
    }

    public function getAchievement(): ?Achievement
    {
        return $this->achievement;
    }

    public function setAchievement(?Achievement $achievement): static
    {
        $this->achievement = $achievement;

        return $this;
    }

    public function getBait(): ?Bait
    {
        return $this->bait;
    }

    public function setBait(?Bait $bait): static
    {
        $this->bait = $bait;

        return $this;
    }

    /**
     * @return Collection<int, FishHole>
     */
    public function getFishHoles(): Collection
    {
        return $this->fishHoles;
    }

    public function addFishHole(FishHole $fishHole): static
    {
        if (!$this->fishHoles->contains($fishHole)) {
            $this->fishHoles->add($fishHole);
            $fishHole->setFish($this);
        }

        return $this;
    }

    public function removeFishHole(FishHole $fishHole): static
    {
        if ($this->fishHoles->removeElement($fishHole)) {
            // set the owning side to null (unless already changed)
            if ($fishHole->getFish() === $this) {
                $fishHole->setFish(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FishTime>
     */
    public function getFishTimes(): Collection
    {
        return $this->fishTimes;
    }

    public function addFishTime(FishTime $fishTime): static
    {
        if (!$this->fishTimes->contains($fishTime)) {
            $this->fishTimes->add($fishTime);
            $fishTime->setFish($this);
        }

        return $this;
    }

    public function removeFishTime(FishTime $fishTime): static
    {
        if ($this->fishTimes->removeElement($fishTime)) {
            // set the owning side to null (unless already changed)
            if ($fishTime->getFish() === $this) {
                $fishTime->setFish(null);
            }
        }

        return $this;
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

    #[Groups('fish')]
    public function getStatus(): ?String
    {
        return $this->status;
    }

    public function setStatus($status): static
    {
        $this->status = $status;
        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->item->getName();
    }
}
