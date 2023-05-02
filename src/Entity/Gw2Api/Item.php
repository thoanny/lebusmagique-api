<?php

namespace App\Entity\Gw2Api;

use App\Entity\Gw2\Fish\Achievement;
use App\Entity\Gw2\Fish\Hole;
use App\Repository\Gw2Api\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ORM\Table(name: 'gw2_api_item')]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    private ?int $uid = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(length: 55)]
    private ?string $type = null;

    #[ORM\Column(length: 55, nullable: true)]
    private ?string $subtype = null;

    #[ORM\Column(length: 25)]
    private ?string $rarity = null;

    #[ORM\Column(nullable: true)]
    private ?bool $blackmarket = null;

    #[ORM\Column]
    private array $data = [];

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $inventoryManagerTip = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $obteningTip = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isFish = null;

    #[ORM\Column(length: 55, nullable: true)]
    private ?string $fishPower = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $fishTime = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $fishSpecialization = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isFishStrangeDietAchievement = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isFishBait = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $fishBaitPower = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Achievement $fishAchievement = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Hole $fishHole = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUid(): ?int
    {
        return $this->uid;
    }

    public function setUid(int $uid): self
    {
        $this->uid = $uid;

        return $this;
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSubtype(): ?string
    {
        return $this->subtype;
    }

    public function setSubtype(?string $subtype): self
    {
        $this->subtype = $subtype;

        return $this;
    }

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function setRarity(string $rarity): self
    {
        $this->rarity = $rarity;

        return $this;
    }

    public function isBlackmarket(): ?bool
    {
        return $this->blackmarket;
    }

    public function setBlackmarket(?bool $blackmarket): self
    {
        $this->blackmarket = $blackmarket;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getInventoryManagerTip(): ?string
    {
        return $this->inventoryManagerTip;
    }

    public function setInventoryManagerTip(?string $inventoryManagerTip): self
    {
        $this->inventoryManagerTip = $inventoryManagerTip;

        return $this;
    }

    public function getObteningTip(): ?string
    {
        return $this->obteningTip;
    }

    public function setObteningTip(?string $obteningTip): self
    {
        $this->obteningTip = $obteningTip;

        return $this;
    }

    public function isFish(): ?bool
    {
        return $this->isFish;
    }

    public function setIsFish(?bool $isFish): self
    {
        $this->isFish = $isFish;

        return $this;
    }

    public function getFishPower(): ?string
    {
        return $this->fishPower;
    }

    public function setFishPower(?string $fishPower): self
    {
        $this->fishPower = $fishPower;

        return $this;
    }

    public function getFishTime(): ?string
    {
        return $this->fishTime;
    }

    public function setFishTime(?string $fishTime): self
    {
        $this->fishTime = $fishTime;

        return $this;
    }

    public function getFishSpecialization(): ?string
    {
        return $this->fishSpecialization;
    }

    public function setFishSpecialization(?string $fishSpecialization): self
    {
        $this->fishSpecialization = $fishSpecialization;

        return $this;
    }

    public function isFishStrangeDietAchievement(): ?bool
    {
        return $this->isFishStrangeDietAchievement;
    }

    public function setIsFishStrangeDietAchievement(?bool $isFishStrangeDietAchievement): self
    {
        $this->isFishStrangeDietAchievement = $isFishStrangeDietAchievement;

        return $this;
    }

    public function isFishBait(): ?bool
    {
        return $this->isFishBait;
    }

    public function setIsFishBait(?bool $isFishBait): self
    {
        $this->isFishBait = $isFishBait;

        return $this;
    }

    public function getFishBaitPower(): ?string
    {
        return $this->fishBaitPower;
    }

    public function setFishBaitPower(?string $fishBaitPower): self
    {
        $this->fishBaitPower = $fishBaitPower;

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

    public function getFishHole(): ?Hole
    {
        return $this->fishHole;
    }

    public function setFishHole(?Hole $fishHole): self
    {
        $this->fishHole = $fishHole;

        return $this;
    }
}
