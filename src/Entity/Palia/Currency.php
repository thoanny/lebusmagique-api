<?php

namespace App\Entity\Palia;

use App\Repository\Palia\CurrencyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
#[ORM\Table(name: 'palia_currency')]
#[Vich\Uploadable]
class Currency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'currency', targetEntity: ItemBuy::class)]
    private Collection $itemBuys;

    #[Vich\UploadableField(mapping: 'palia_currency_icon', fileNameProperty: 'icon')]
    private ?File $iconFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->itemBuys = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, ItemBuy>
     */
    public function getItemBuys(): Collection
    {
        return $this->itemBuys;
    }

    public function addItemBuy(ItemBuy $itemBuy): self
    {
        if (!$this->itemBuys->contains($itemBuy)) {
            $this->itemBuys->add($itemBuy);
            $itemBuy->setCurrency($this);
        }

        return $this;
    }

    public function removeItemBuy(ItemBuy $itemBuy): self
    {
        if ($this->itemBuys->removeElement($itemBuy)) {
            // set the owning side to null (unless already changed)
            if ($itemBuy->getCurrency() === $this) {
                $itemBuy->setCurrency(null);
            }
        }

        return $this;
    }

    public function setIconFile(?File $iconFile = null): void
    {
        $this->iconFile = $iconFile;

        if (null !== $iconFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getIconFile(): ?File
    {
        return $this->iconFile;
    }

    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }
}
