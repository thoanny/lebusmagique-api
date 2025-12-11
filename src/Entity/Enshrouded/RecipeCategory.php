<?php

namespace App\Entity\Enshrouded;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NestedTreeRepository::class)]
#[ORM\Table(name: 'enshrouded_recipe_category')]
#[Gedmo\Tree(type: 'nested')]
class RecipeCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['recipes'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['recipes'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Recipe::class)]
    #[Groups(['recipes'])]
    private Collection $recipes;

    #[Gedmo\TreeLeft]
    #[ORM\Column(name: 'lft')]
    private int $lft;

    #[Gedmo\TreeLevel]
    #[ORM\Column(name: 'lvl')]
    private int $lvl;

    #[Gedmo\TreeRight]
    #[ORM\Column(name: 'rgt')]
    private int $rgt;

    #[Gedmo\TreeRoot]
    #[ORM\ManyToOne(targetEntity: RecipeCategory::class)]
    #[ORM\JoinColumn(name: 'tree_root', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private $root;

    #[Gedmo\TreeParent]
    #[ORM\ManyToOne(targetEntity: RecipeCategory::class, inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?RecipeCategory $parent = null;

    #[ORM\OneToMany(targetEntity: RecipeCategory::class, mappedBy: 'parent')]
    #[ORM\OrderBy(['lft' => 'ASC'])]
    private $children;

    public function __construct()
    {
        $this->recipes = new ArrayCollection();
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
            $recipe->setCategory($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): static
    {
        if ($this->recipes->removeElement($recipe)) {
            // set the owning side to null (unless already changed)
            if ($recipe->getCategory() === $this) {
                $recipe->setCategory(null);
            }
        }

        return $this;
    }

    public function getRoot(): ?self
    {
        return $this->root;
    }

    public function setParent(self $parent = null): void
    {
        $this->parent = $parent;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    #[Groups(['recipes'])]
    public function getParentId(): ?int {
        return $this->parent?->id;
    }

    #[Groups(['recipes'])]
    public function getRecipesCount(): ?int {
        return count($this->recipes);
    }


    public function __toString(): string
    {
        $level = '';
        if($this->lvl > 0) {
            for($i = 0; $i < $this->lvl; $i++) {
                $level .= '-';
            }
        }
        return "$level $this->name";
    }
}
