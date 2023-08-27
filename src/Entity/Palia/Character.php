<?php

namespace App\Entity\Palia;

use App\Repository\Palia\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: 'palia_character')]
#[Vich\Uploadable]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?bool $romance = null;

    #[ORM\Column(nullable: true)]
    private ?bool $shepp = null;

    #[ORM\ManyToMany(targetEntity: Location::class, inversedBy: 'characters')]
    #[ORM\JoinTable(name: 'palia_character_location')]
    private Collection $locations;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    private ?CharacterGroup $characterGroup = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Skill $skill = null;

    #[ORM\OneToMany(mappedBy: 'paliaCharacter', targetEntity: CharacterWish::class, orphanRemoval: true)]
    private Collection $wishes;

    #[ORM\OneToMany(mappedBy: 'paliaCharacter', targetEntity: CharacterGift::class, orphanRemoval: true)]
    private Collection $gifts;

    #[Vich\UploadableField(mapping: 'palia_character_avatar', fileNameProperty: 'avatar')]
    private ?File $avatarFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $avatar = null;

    #[Vich\UploadableField(mapping: 'palia_character_illustration', fileNameProperty: 'illustration')]
    private ?File $illustrationFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $illustration = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->wishes = new ArrayCollection();
        $this->gifts = new ArrayCollection();
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

    public function isRomance(): ?bool
    {
        return $this->romance;
    }

    public function setRomance(?bool $romance): self
    {
        $this->romance = $romance;

        return $this;
    }

    public function isShepp(): ?bool
    {
        return $this->shepp;
    }

    public function setShepp(?bool $shepp): self
    {
        $this->shepp = $shepp;

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations->add($location);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        $this->locations->removeElement($location);

        return $this;
    }

    public function getCharacterGroup(): ?CharacterGroup
    {
        return $this->characterGroup;
    }

    public function setCharacterGroup(?CharacterGroup $characterGroup): self
    {
        $this->characterGroup = $characterGroup;

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * @return Collection<int, CharacterWish>
     */
    public function getWishes(): Collection
    {
        return $this->wishes;
    }

    public function addWish(CharacterWish $wish): self
    {
        if (!$this->wishes->contains($wish)) {
            $this->wishes->add($wish);
            $wish->setPaliaCharacter($this);
        }

        return $this;
    }

    public function removeWish(CharacterWish $wish): self
    {
        if ($this->wishes->removeElement($wish)) {
            // set the owning side to null (unless already changed)
            if ($wish->getPaliaCharacter() === $this) {
                $wish->setPaliaCharacter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CharacterGift>
     */
    public function getGifts(): Collection
    {
        return $this->gifts;
    }

    public function addGift(CharacterGift $gift): self
    {
        if (!$this->gifts->contains($gift)) {
            $this->gifts->add($gift);
            $gift->setPaliaCharacter($this);
        }

        return $this;
    }

    public function removeGift(CharacterGift $gift): self
    {
        if ($this->gifts->removeElement($gift)) {
            // set the owning side to null (unless already changed)
            if ($gift->getPaliaCharacter() === $this) {
                $gift->setPaliaCharacter(null);
            }
        }

        return $this;
    }

    public function setAvatarFile(?File $avatarFile = null): void
    {
        $this->avatarFile = $avatarFile;

        if (null !== $avatarFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getAvatarFile(): ?File
    {
        return $this->avatarFile;
    }

    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setIllustrationFile(?File $illustrationFile = null): void
    {
        $this->illustrationFile = $illustrationFile;

        if (null !== $illustrationFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getIllustrationFile(): ?File
    {
        return $this->illustrationFile;
    }

    public function setIllustration(?string $illustration): void
    {
        $this->illustration = $illustration;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }
}
