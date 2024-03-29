<?php

namespace App\Entity\Gw2\Fish;

use App\Entity\Gw2Api\Item;
use App\Repository\Gw2\Fish\HoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HoleRepository::class)]
#[ORM\Table(name: 'gw2_fish_hole')]
class Hole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('fish')]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    #[Groups('fish')]
    private ?string $name = null;

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
}
