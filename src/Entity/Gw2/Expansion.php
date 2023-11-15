<?php

namespace App\Entity\Gw2;

use App\Repository\Gw2\ExpansionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ExpansionRepository::class)]
#[ORM\Table(name: 'gw2_expansion')]
class Expansion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    #[Groups(['api'])]
    private ?string $uid = null;

    #[ORM\Column(length: 255)]
    #[Groups(['api'])]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(string $uid): static
    {
        $this->uid = $uid;

        return $this;
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
