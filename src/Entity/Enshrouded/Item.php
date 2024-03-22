<?php

namespace App\Entity\Enshrouded;

use App\Repository\Enshrouded\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ORM\Table(name: 'enshrouded_item')]
#[Vich\Uploadable]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['items', 'recipe', 'recipes', 'searchable'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['item', 'items', 'recipe', 'recipes', 'searchable'])]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['item', 'recipe'])]
    private ?int $level = null;

    #[ORM\Column(length: 25)]
    #[Groups(['item', 'items', 'recipe', 'searchable'])]
    private ?string $quality = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['item', 'recipe', 'searchable'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['item', 'recipe'])]
    private ?string $comment = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['item', 'items', 'recipe', 'searchable'])]
    private ?ItemCategory $category = null;

    #[ORM\Column(length: 25, nullable: true)]
    #[Groups(['item', 'recipe', 'recipe'])]
    private ?string $equippable = null;

    #[ORM\OneToMany(mappedBy: 'outputItem', targetEntity: Recipe::class)]
    #[Groups(['item'])]
    private Collection $recipes;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: RecipeIngredient::class, orphanRemoval: true)]
    #[Groups(['item'])]
    private Collection $recipeIngredients;

    #[Vich\UploadableField(mapping: 'enshrouded_item_icon', fileNameProperty: 'icon')]
    private ?File $iconFile = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['item', 'items', 'recipe', 'recipes', 'searchable'])]
    private ?string $icon = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->recipes = new ArrayCollection();
        $this->recipeIngredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getQuality(): ?string
    {
        return $this->quality;
    }

    public function setQuality(string $quality): static
    {
        $this->quality = $quality;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCategory(): ?ItemCategory
    {
        return $this->category;
    }

    public function setCategory(?ItemCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getEquippable(): ?string
    {
        return $this->equippable;
    }

    public function setEquippable(?string $equippable): static
    {
        $this->equippable = $equippable;

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipe $recipe): static
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes->add($recipe);
            $recipe->setOutputItem($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): static
    {
        if ($this->recipes->removeElement($recipe)) {
            // set the owning side to null (unless already changed)
            if ($recipe->getOutputItem() === $this) {
                $recipe->setOutputItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RecipeIngredient>
     */
    public function getRecipeIngredients(): Collection
    {
        return $this->recipeIngredients;
    }

    public function addRecipeIngredient(RecipeIngredient $recipeIngredient): static
    {
        if (!$this->recipeIngredients->contains($recipeIngredient)) {
            $this->recipeIngredients->add($recipeIngredient);
            $recipeIngredient->setItem($this);
        }

        return $this;
    }

    public function removeRecipeIngredient(RecipeIngredient $recipeIngredient): static
    {
        if ($this->recipeIngredients->removeElement($recipeIngredient)) {
            // set the owning side to null (unless already changed)
            if ($recipeIngredient->getItem() === $this) {
                $recipeIngredient->setItem(null);
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

    #[Groups(['item', 'items', 'recipe', 'recipes'])]
    public function getIcon96x96(): ?string
    {
        return ($this->icon) ? "/media/cache/resolve/enshrouded_item_icon_96/uploads/api/enshrouded/items/$this->icon" : null;
    }

    #[Groups(['item', 'items', 'recipe', 'recipes'])]
    public function getIcon48x48(): ?string
    {
        return ($this->icon) ? "/media/cache/resolve/enshrouded_item_icon_48/uploads/api/enshrouded/items/$this->icon" : null;
    }

    #[Groups(['item', 'items', 'recipe', 'recipes'])]
    public function getIcon24x24(): ?string
    {
        return ($this->icon) ? "/media/cache/resolve/enshrouded_item_icon_24/uploads/api/enshrouded/items/$this->icon" : null;
    }

    #[Groups(['searchable'])]
    public function qualityName(): ?string
    {
        $qualityNames = [
            'common' => "Ordinaire",
            'uncommon' => "Peu courant",
            'rare' => "Rare",
            'epic' => "Épique",
            'legendary' => "Légendaire"
        ];

        if(!isset($qualityNames[$this->quality])) {
            return $this->quality;
        }

        return $qualityNames[$this->quality];
    }

    #[Groups(['searchable'])]
    public function hasRecipes(): ?bool
    {
        return $this->recipes > 0;
    }
}
