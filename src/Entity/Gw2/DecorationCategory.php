<?php

namespace App\Entity\Gw2;

use App\Repository\Gw2\DecorationCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DecorationCategoryRepository::class)]
#[ORM\Table(name: 'gw2_decoration_category')]
class DecorationCategory implements \Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['decorations-categories'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['decorations-categories'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Decoration::class, orphanRemoval: true)]
    #[Groups(['decorations-categories'])]
    private Collection $decorations;

    public function __construct()
    {
        $this->decorations = new ArrayCollection();
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

    public function __toString(): string
    {
        return (string) $this->name;
    }

    /**
     * @return Collection<int, Decoration>
     */
    public function getDecorations(): Collection
    {
        return $this->decorations;
    }

    public function addDecoration(Decoration $decoration): static
    {
        if (!$this->decorations->contains($decoration)) {
            $this->decorations->add($decoration);
            $decoration->setCategory($this);
        }

        return $this;
    }

    public function removeDecoration(Decoration $decoration): static
    {
        if ($this->decorations->removeElement($decoration)) {
            // set the owning side to null (unless already changed)
            if ($decoration->getCategory() === $this) {
                $decoration->setCategory(null);
            }
        }

        return $this;
    }
}
