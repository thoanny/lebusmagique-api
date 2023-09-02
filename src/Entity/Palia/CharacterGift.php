<?php

namespace App\Entity\Palia;

use App\Repository\Palia\CharacterGiftRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterGiftRepository::class)]
#[ORM\Table(name: 'palia_character_gift')]
class CharacterGift
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'characterGifts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Item $item = null;

    #[ORM\ManyToOne(inversedBy: 'gifts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Character $paliaCharacter = null;

    #[ORM\Column(nullable: true)]
    private ?bool $love = null;

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

    public function isLove(): ?bool
    {
        return $this->love;
    }

    public function setLove(?bool $love): self
    {
        $this->love = $love;

        return $this;
    }
}
