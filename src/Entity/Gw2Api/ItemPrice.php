<?php

namespace App\Entity\Gw2Api;

use App\Repository\Gw2Api\ItemPriceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ItemPriceRepository::class)]
#[ORM\Table(name: 'gw2_api_item_price')]
class ItemPrice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups('price')]
    private ?int $buysQuantity = null;

    #[ORM\Column]
    #[Groups('price')]
    private ?int $buysUnitPrice = null;

    #[ORM\Column]
    #[Groups('price')]
    private ?int $sellsQuantity = null;

    #[ORM\Column]
    #[Groups('price')]
    private ?int $sellsUnitPrice = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 55)]
    private ?string $checksum = null;

    #[ORM\OneToOne(inversedBy: 'itemPrice', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Item $item = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBuysQuantity(): ?int
    {
        return $this->buysQuantity;
    }

    public function setBuysQuantity(int $buysQuantity): self
    {
        $this->buysQuantity = $buysQuantity;

        return $this;
    }

    public function getBuysUnitPrice(): ?int
    {
        return $this->buysUnitPrice;
    }

    public function setBuysUnitPrice(int $buysUnitPrice): self
    {
        $this->buysUnitPrice = $buysUnitPrice;

        return $this;
    }

    public function getSellsQuantity(): ?int
    {
        return $this->sellsQuantity;
    }

    public function setSellsQuantity(int $sellsQuantity): self
    {
        $this->sellsQuantity = $sellsQuantity;

        return $this;
    }

    public function getSellsUnitPrice(): ?int
    {
        return $this->sellsUnitPrice;
    }

    public function setSellsUnitPrice(int $sellsUnitPrice): self
    {
        $this->sellsUnitPrice = $sellsUnitPrice;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getChecksum(): ?string
    {
        return $this->checksum;
    }

    public function setChecksum(string $checksum): self
    {
        $this->checksum = $checksum;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(Item $item): self
    {
        $this->item = $item;

        return $this;
    }
}
