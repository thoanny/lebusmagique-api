<?php

namespace App\Entity\Enshrouded;

use App\Repository\Enshrouded\ItemCategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ItemCategoryRepository::class)]
#[ORM\Table(name: 'enshrouded_item_category')]
class ItemCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['categories', 'item', 'items', 'recipe'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['categories', 'item', 'items', 'recipe'])]
    private ?string $name = null;

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
}
