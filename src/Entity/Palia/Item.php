<?php

namespace App\Entity\Palia;

use App\Repository\Palia\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ORM\Table(name: 'palia_item')]
#[Vich\Uploadable]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['api', 'recipe'])]
    private ?string $name = null;

    #[ORM\Column(length: 10, nullable: true)]
    #[Groups(['api'])]
    private ?string $rarity = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['api'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['api'])]
    private ?int $focus = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['api'])]
    private ?int $focusQuality = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['api'])]
    private ?int $priceBase = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['api'])]
    private ?int $priceQuality = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['api'])]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[Groups(['api'])]
    private ?ItemCategory $category = null;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: CharacterWish::class, orphanRemoval: true)]
    private Collection $characterWishes;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: CharacterGift::class, orphanRemoval: true)]
    private Collection $characterGifts;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: Recipe::class, orphanRemoval: true)]
    private Collection $recipes;

    #[ORM\ManyToMany(targetEntity: Location::class)]
    #[ORM\JoinTable(name: 'palia_item_location')]
    #[Groups(['api'])]
    private Collection $locations;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: ItemBuy::class, orphanRemoval: true)]
    private Collection $purchases;

    #[Vich\UploadableField(mapping: 'palia_item_icon', fileNameProperty: 'icon')]
    private ?File $iconFile = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['api', 'recipe'])]
    private ?string $icon = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 128, unique: true)]
    #[Gedmo\Slug(fields: ['name'])]
    #[Groups(['api', 'recipe'])]
    private $slug;

    public function __construct()
    {
        $this->characterWishes = new ArrayCollection();
        $this->characterGifts = new ArrayCollection();
        $this->recipes = new ArrayCollection();
        $this->locations = new ArrayCollection();
        $this->purchases = new ArrayCollection();
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

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function setRarity(string $rarity): self
    {
        $this->rarity = $rarity;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFocus(): ?int
    {
        return $this->focus;
    }

    public function setFocus(?int $focus): self
    {
        $this->focus = $focus;

        return $this;
    }

    public function getFocusQuality(): ?int
    {
        return $this->focusQuality;
    }

    public function setFocusQuality(?int $focusQuality): self
    {
        $this->focusQuality = $focusQuality;

        return $this;
    }

    public function getPriceBase(): ?int
    {
        return $this->priceBase;
    }

    public function setPriceBase(int $priceBase): self
    {
        $this->priceBase = $priceBase;

        return $this;
    }

    public function getPriceQuality(): ?int
    {
        return $this->priceQuality;
    }

    public function setPriceQuality(int $priceQuality): self
    {
        $this->priceQuality = $priceQuality;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCategory(): ?ItemCategory
    {
        return $this->category;
    }

    public function setCategory(?ItemCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, CharacterWish>
     */
    public function getCharacterWishes(): Collection
    {
        return $this->characterWishes;
    }

    public function addCharacterWish(CharacterWish $characterWish): self
    {
        if (!$this->characterWishes->contains($characterWish)) {
            $this->characterWishes->add($characterWish);
            $characterWish->setItem($this);
        }

        return $this;
    }

    public function removeCharacterWish(CharacterWish $characterWish): self
    {
        if ($this->characterWishes->removeElement($characterWish)) {
            // set the owning side to null (unless already changed)
            if ($characterWish->getItem() === $this) {
                $characterWish->setItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CharacterGift>
     */
    public function getCharacterGifts(): Collection
    {
        return $this->characterGifts;
    }

    public function addCharacterGift(CharacterGift $characterGift): self
    {
        if (!$this->characterGifts->contains($characterGift)) {
            $this->characterGifts->add($characterGift);
            $characterGift->setItem($this);
        }

        return $this;
    }

    public function removeCharacterGift(CharacterGift $characterGift): self
    {
        if ($this->characterGifts->removeElement($characterGift)) {
            // set the owning side to null (unless already changed)
            if ($characterGift->getItem() === $this) {
                $characterGift->setItem(null);
            }
        }

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

    /**
     * @return Collection<int, Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations->add($location);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        $this->locations->removeElement($location);

        return $this;
    }

    /**
     * @return Collection<int, ItemBuy>
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(ItemBuy $purchase): self
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases->add($purchase);
            $purchase->setItem($this);
        }

        return $this;
    }

    public function removePurchase(ItemBuy $purchase): self
    {
        if ($this->purchases->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getItem() === $this) {
                $purchase->setItem(null);
            }
        }

        return $this;
    }

    public function setIconFile(?File $iconFile = null): void
    {
        $this->iconFile = $iconFile;

        if (null !== $iconFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getIconFile(): ?File
    {
        return $this->iconFile;
    }

    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getSlug()
    {
        return $this->slug;
    }
    #[Groups('api')]
    public function getRecipesCount() {
        return count($this->getRecipes());
    }
}
