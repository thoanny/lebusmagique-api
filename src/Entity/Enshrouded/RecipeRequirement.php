<?php

namespace App\Entity\Enshrouded;

use App\Repository\Enshrouded\RecipeRequirementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RecipeRequirementRepository::class)]
#[ORM\Table(name: 'enshrouded_recipe_requirement')]
class RecipeRequirement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['recipe'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'requirements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipe $recipe = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['recipe'])]
    private ?RecipeSource $source = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): static
    {
        $this->recipe = $recipe;

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
}
