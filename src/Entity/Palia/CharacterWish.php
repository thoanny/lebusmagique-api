<?php

namespace App\Entity\Palia;

use App\Repository\Palia\CharacterWishRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterWishRepository::class)]
#[ORM\Table(name: 'palia_character_wish')]
class CharacterWish
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'characterWishes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Item $item = null;

    #[ORM\ManyToOne(inversedBy: 'wishes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Character $paliaCharacter = null;

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

    public function getPaliaCharacter(): ?Character
    {
        return $this->paliaCharacter;
    }

    public function setPaliaCharacter(?Character $paliaCharacter): self
    {
        $this->paliaCharacter = $paliaCharacter;

        return $this;
    }
}
