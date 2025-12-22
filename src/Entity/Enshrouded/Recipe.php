<?php

namespace App\Entity\Enshrouded;

use App\Repository\Enshrouded\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[ORM\Table(name: 'enshrouded_recipe')]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['item', 'recipes'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    private ?RecipeCategory $category = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[Groups(['recipes'])]
    private ?RecipeSource $source = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['recipe', 'recipes'])]
    private ?Item $outputItem = null;

    #[ORM\Column]
    #[Groups(['recipe'])]
    private ?int $outputQuantity = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['recipe'])]
    private ?int $outputDuration = null;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: RecipeRequirement::class, cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['recipe'])]
    private Collection $requirements;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: RecipeIngredient::class, cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['recipe'])]
    private Collection $ingredients;

    public function __construct()
    {
        $this->requirements = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?RecipeCategory
    {
        return $this->category;
    }

    public function setCategory(?RecipeCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getSource(): ?RecipeSource
    {
        return $this->source;
    }

    public function setSource(?RecipeSource $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getOutputItem(): ?Item
    {
        return $this->outputItem;
    }

    public function setOutputItem(?Item $outputItem): static
    {
        $this->outputItem = $outputItem;

        return $this;
    }

    public function getOutputQuantity(): ?int
    {
        return $this->outputQuantity;
    }

    public function setOutputQuantity(int $outputQuantity): static
    {
        $this->outputQuantity = $outputQuantity;

        return $this;
    }

    public function getOutputDuration(): ?int
    {
        return $this->outputDuration;
    }

    public function setOutputDuration(?int $outputDuration): static
    {
        $this->outputDuration = $outputDuration;

        return $this;
    }

    /**
     * @return Collection<int, RecipeRequirement>
     */
    public function getRequirements(): Collection
    {
        return $this->requirements;
    }

    public function addRequirement(RecipeRequirement $recipeRequirement): static
    {
        if (!$this->requirements->contains($recipeRequirement)) {
            $this->requirements->add($recipeRequirement);
            $recipeRequirement->setRecipe($this);
        }

        return $this;
    }

    public function removeRequirement(RecipeRequirement $recipeRequirement): static
    {
        if ($this->requirements->removeElement($recipeRequirement)) {
            // set the owning side to null (unless already changed)
            if ($recipeRequirement->getRecipe() === $this) {
                $recipeRequirement->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RecipeIngredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(RecipeIngredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setRecipe($this);
        }

        return $this;
    }

    public function removeIngredient(RecipeIngredient $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getRecipe() === $this) {
                $ingredient->setRecipe(null);
            }
        }

        return $this;
    }

    #[Groups(['item'])]
    public function getName(): ?string {
        return $this->getOutputItem()->getName();
    }
}
