<?php

namespace App\Entity\Gw2Api;

use App\Entity\Gw2\Expansion;
use App\Repository\Gw2Api\WizardVaultObjectiveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: WizardVaultObjectiveRepository::class)]
#[ORM\Table(name: 'gw2_api_wizard_vault_objective')]
class WizardVaultObjective
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $uid = null;

    #[ORM\Column(length: 255)]
    #[Groups(['api'])]
    private ?string $title = null;

    #[ORM\Column(length: 10)]
    #[Groups(['api'])]
    private ?string $period = null;

    #[ORM\Column(length: 3)]
    #[Groups(['api'])]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['api'])]
    private ?string $tip = null;

    #[ORM\Column]
    #[Groups(['api'])]
    private ?int $astralAcclaim = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    #[ORM\ManyToMany(targetEntity: Expansion::class)]
    #[ORM\JoinTable(name: 'gw2_api_wizard_vault_objective_expansion')]
    #[Groups(['api'])]
    private Collection $expansion;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->expansion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUid(): ?int
    {
        return $this->uid;
    }

    public function setUid(?int $uid): static
    {
        $this->uid = $uid;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPeriod(): ?string
    {
        return $this->period;
    }

    public function setPeriod(string $period): static
    {
        $this->period = $period;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getTip(): ?string
    {
        return $this->tip;
    }

    public function setTip(string $tip): static
    {
        $this->tip = $tip;

        return $this;
    }

    public function getAstralAcclaim(): ?int
    {
        return $this->astralAcclaim;
    }

    public function setAstralAcclaim(int $astralAcclaim): static
    {
        $this->astralAcclaim = $astralAcclaim;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, Expansion>
     */
    public function getExpansion(): Collection
    {
        return $this->expansion;
    }

    public function addExpansion(Expansion $expansion): static
    {
        if (!$this->expansion->contains($expansion)) {
            $this->expansion->add($expansion);
        }

        return $this;
    }

    public function removeExpansion(Expansion $expansion): static
    {
        $this->expansion->removeElement($expansion);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
