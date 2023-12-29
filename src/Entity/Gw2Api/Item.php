<?php

namespace App\Entity\Gw2Api;

use App\Entity\Gw2\Fish\Bait;
use App\Entity\Gw2\Fish\Fish;
use App\Repository\Gw2Api\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ORM\Table(name: 'gw2_api_item')]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    #[Groups(['item', 'fish'])]
    private ?int $uid = null;

    #[ORM\Column(length: 255)]
    #[Groups(['item', 'fish'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(length: 55)]
    #[Groups('item')]
    private ?string $type = null;

    #[ORM\Column(length: 55, nullable: true)]
    #[Groups('item')]
    private ?string $subtype = null;

    #[ORM\Column(length: 25)]
    #[Groups(['item', 'fish'])]
    private ?string $rarity = null;

    #[ORM\Column(nullable: true)]
    #[Groups('item')]
    private ?bool $blackmarket = null;

    #[ORM\Column]
    #[Groups(['item'])]
    private array $data = [];

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $inventoryManagerTip = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $obteningTip = null;

    #[ORM\OneToOne(mappedBy: 'item', cascade: ['persist', 'remove'])]
    #[Groups('item')]
    private ?ItemPrice $itemPrice = null;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: Recipe::class, cascade: ['persist'], orphanRemoval: true)]
    #[Groups('item')]
    private Collection $recipes;

    #[ORM\OneToOne(mappedBy: 'item', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private ?Bait $bait = null;

    #[ORM\OneToOne(mappedBy: 'item', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private ?Fish $fish = null;

    public function __construct()
    {
        $this->recipes = new ArrayCollection();
    }

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

    public function getItemPrice(): ?ItemPrice
    {
        return $this->itemPrice;
    }

    public function setItemPrice(ItemPrice $itemPrice): self
    {
        // set the owning side of the relation if necessary
        if ($itemPrice->getItem() !== $this) {
            $itemPrice->setItem($this);
        }

        $this->itemPrice = $itemPrice;

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipe $recipe): self
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes->add($recipe);
            $recipe->setItem($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): self
    {
        if ($this->recipes->removeElement($recipe)) {
            // set the owning side to null (unless already changed)
            if ($recipe->getItem() === $this) {
                $recipe->setItem(null);
            }
        }

        return $this;
    }

    public function getBait(): ?Bait
    {
        return $this->bait;
    }

    public function setBait(?Bait $bait): static
    {
        // unset the owning side of the relation if necessary
        if($bait === null && $this->bait !== null) {
            $this->bait->setItem(null);
        }
        // set the owning side of the relation if necessary
        if ($bait !== null && $bait->getItem() !== $this) {
            $bait->setItem($this);
        }

        $this->bait = $bait;

        return $this;
    }

    public function getFish(): ?Fish
    {
        return $this->fish;
    }

    public function setFish(?Fish $fish): static
    {
        // unset the owning side of the relation if necessary
        if ($fish === null && $this->fish !== null) {
            $this->fish->setItem(null);
        }

        // set the owning side of the relation if necessary
        if ($fish !== null && $fish->getItem() !== $this) {
            $fish->setItem($this);
        }

        $this->fish = $fish;

        return $this;
    }

    #[Groups(['fish'])]
    public function getIcon() {
        return (isset($this->data['icon'])) ? $this->data['icon'] : null;
    }
}
