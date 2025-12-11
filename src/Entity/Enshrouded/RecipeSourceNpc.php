<?php

namespace App\Entity\Enshrouded;

use App\Repository\Enshrouded\RecipeSourceNpcRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RecipeSourceNpcRepository::class)]
#[ORM\Table(name: 'enshrouded_recipe_source_npc')]
class RecipeSourceNpc extends RecipeSource implements \Stringable
{
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['recipe'])]
    private ?Npc $npc = null;

    public function getNpc(): ?Npc
    {
        return $this->npc;
    }

    public function setNpc(Npc $npc): static
    {
        $this->npc = $npc;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    #[Groups(['recipes', 'recipes_sources'])]
    public function getName(): string
    {
        return $this->getNpc()->getName();
    }
    #[Groups(['recipe', 'recipes', 'recipes_sources'])]
    public function getType(): string
    {
        return 'npc';
    }

}
