<?php

namespace App\Entity\Palia;

use App\Repository\Palia\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[ORM\Table(name: 'palia_recipe')]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('recipe')]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('recipe')]
    private ?Item $item = null;

    #[ORM\Column]
    #[Groups('recipe')]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('recipe')]
    private ?Item $workshop = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[Groups('recipe')]
    private ?Skill $skill = null;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: RecipeIngredient::class, cascade: ['persist'], orphanRemoval: true)]
    #[Groups('recipe')]
    private Collection $ingredients;

    #[ORM\Column(nullable: true)]
    #[Groups('recipe')]
    private ?int $craftTime = null;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getWorkshop(): ?Item
    {
        return $this->workshop;
    }

    public function setWorkshop(?Item $workshop): self
    {
        $this->workshop = $workshop;

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * @return Collection<int, RecipeIngredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(RecipeIngredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setRecipe($this);
        }

        return $this;
    }

    public function removeIngredient(RecipeIngredient $ingredient): self
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getRecipe() === $this) {
                $ingredient->setRecipe(null);
            }
        }

        return $this;
    }

    public function getCraftTime(): ?int
    {
        return $this->craftTime;
    }

    public function setCraftTime(?int $craftTime): static
    {
        $this->craftTime = $craftTime;

        return $this;
    }
}
