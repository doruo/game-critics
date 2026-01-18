<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use App\Entity\Critic;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Link;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;
use App\State\GameProcessor;
use App\State\GameProvider;
use App\State\UnvalidatedGameProvider;
use DateTime;

/**
 * Criticable game object.
 * */
#[UniqueEntity('name', message: "Ce jeu existe déjà.")]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_NAME', fields: ['name'])]
#[ORM\Entity(repositoryClass: GameRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ["groups" => ["serialization:game:read"]],
            provider: GameProvider::class
        ),

        // unvalidated
        new GetCollection(
            uriTemplate: '/unvalidatedGames',
            normalizationContext: ["groups" => ["serialization:game:read"]],
            security: "is_granted('AUTH_ADMIN', null)",
            securityMessage: "Vous devez être admin pour accéder à cette route",
            provider: UnvalidatedGameProvider::class
        ),

        new Get(
            normalizationContext: ["groups" => ["serialization:game:read"]],
            security: "is_granted('GAME_IS_PUBLIC_OR_ADMIN', object)",
            securityMessage: "Le jeu doit être approuver ou vous devez être admin pour acceder à cette route"
        ),

        new Post(
            normalizationContext: ["groups" => ["serialization:game:read"]],
            denormalizationContext: ["groups" => ["deserialization:game:create"]],
            validationContext: ["groups" => ["Default", "validation:game:create"]],
            security: "is_granted('AUTH_CONNECTED', null)",
            processor: GameProcessor::class
        ),

        new Patch(
            normalizationContext: ["groups" => ["serialization:game:read"]],
            denormalizationContext: ["groups" => ["deserialization:game:update"]],
            validationContext: ["groups" => ["Default", "validation:game:update"]],
            security: "is_granted('AUTH_ADMIN',null)",
            securityMessage: "Vous devez être admin pour accéder à cette route",
        ),

        new Delete(
            security: "is_granted('AUTH_ADMIN',null)",
            securityMessage: "Vous devez être admin pour accéder à cette route",
        ),
    ]
)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(
        description: "id",
        readable: true,
        writable: false
    )]
    #[Groups(['serialization:game:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    #[ApiProperty(description: "Nom du jeu vidéo")]
    #[Assert\NotBlank(groups: ["validation:game:create"])]
    #[Assert\NotNull(groups: ["validation:game:create"])]
    #[Assert\Length(
        min: 4,
        max: 40,
        minMessage: "Le nom doit faire au minimum 4 caractères.",
        maxMessage: "Le nom doit faire au maximum 40 caractères."
    )]
    #[Groups([
        'serialization:game:read',
        'deserialization:game:create',
        'deserialization:game:update'
    ])]
    private ?string $name = null;

    #[ORM\Column(length: 500,nullable: true)]
    #[ApiProperty(description: "Description détaillée du jeu")]
    #[Assert\Length(
        min: 4,
        max: 500,
        minMessage: "La description doit faire au minimum 4 caractères.",
        maxMessage: "La description doit faire au maximum 500 caractères."
    )]
    #[Groups([
        'serialization:game:read',
        'deserialization:game:create',
        'deserialization:game:update'
    ])]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime')]
    #[ApiProperty(description: "Date de sortie officielle du jeu")]
    #[Assert\NotNull(groups: ["validation:game:create"])]
    #[Assert\LessThanOrEqual(value: "today",groups: ["validation:game:create", "validation:game:update"])]
    #[Groups([
        'serialization:game:read',
        'deserialization:game:create',
        'deserialization:game:update'
    ])]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\Column(length: 60)]
    #[ApiProperty(description: "Studio de développement du jeu")]
    #[Assert\NotBlank(groups: ["validation:game:create"])]
    #[Assert\Length(
        min: 1,
        max: 60,
        minMessage: "Le nom du studio doit faire au minimum 1 caractère.",
        maxMessage: "Le nom du studio doit faire au maximum 60 caractères."
    )]
    #[Groups([
        'serialization:game:read',
        'deserialization:game:create',
        'deserialization:game:update'
    ])]
    private ?string $developper = null;

    #[ORM\Column(length: 60,nullable: true)]
    #[ApiProperty(description: "Éditeur du jeu")]
    #[Assert\Length(
        min: 1,
        max: 60,
        minMessage: "Le nom de l'éditeur doit faire au minimum 1 caractère.",
        maxMessage: "Le nom de l'éditeur doit faire au maximum 60 caractères."
    )]
    #[Groups([
        'serialization:game:read',
        'deserialization:game:create',
        'deserialization:game:update'
    ])]
    private ?string $publisher = null;

    #[ApiProperty(
        description: "Note moyenne du jeu calculée à partir des critiques",
        readable: true,
        writable: false
    )]
    #[Groups(['serialization:game:read'])]
    private ?float $avgNote = null;

    #[ORM\Column(length: 50,nullable: true)]
    #[ApiProperty(description: "Mode de jeu")]
    #[Assert\Length(
        min: 1,
        max: 50,
        minMessage: "Le gameMode doit faire au minimum 1 caractère.",
        maxMessage: "Le gameMode doit faire au maximum 50 caractères."
    )]
    #[Groups([
        'serialization:game:read',
        'deserialization:game:create',
        'deserialization:game:update'
    ])]
    private ?string $gameMode = null;

    #[ORM\Column(nullable: true)]
    #[ApiProperty(description: "Age minimum recommander pour jouer au jeu")]
    #[Groups([
        'serialization:game:read',
        'deserialization:game:create',
        'deserialization:game:update'
    ])]
    private ?int $targetAge = null;

    #[ORM\Column(length: 50,nullable: true)]
    #[ApiProperty(description: "Genre principal du jeu")]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: "Le genre doit faire au minimum 3 caractères.",
        maxMessage: "Le genre doit faire au maximum 50 caractères."
    )]
    #[Groups([
        'serialization:game:read',
        'deserialization:game:create',
        'deserialization:game:update'
    ])]
    private ?string $genre = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[ApiProperty(description: "Licence associée au jeu")]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: "La licence doit faire au minimum 3 caractères.",
        maxMessage: "La licence doit faire au maximum 50 caractères."
    )]
    #[Groups([
        'serialization:game:read',
        'deserialization:game:create',
        'deserialization:game:update'
    ])]
    private ?string $licence = null;

    #[ORM\Column]
    #[Assert\NotBlank(groups: ["validation:game:create"])]
    #[ApiProperty(description: "Prix du jeu")]
    #[Groups([
        'serialization:game:read',
        'deserialization:game:create',
        'deserialization:game:update'
    ])]
    private ?float $price = null;

    /**
     * @var list<string>
     */
    #[ORM\Column(nullable: true)]
    #[ApiProperty(description: "Plateformes supportées")]
    #[Groups([
        'serialization:game:read',
        'deserialization:game:create',
        'deserialization:game:update'
    ])]
    private ?array $plateform = null;

    /**
     * @var list<string>
     *
     * Liens vers les images et captures d'écran du jeu
     */
    #[ORM\Column(nullable: true)]
    #[ApiProperty(description: "Images et captures d'écran du jeu")]
    #[Groups([
        'serialization:game:read',
        'deserialization:game:create',
        'deserialization:game:update'
    ])]
    private ?array $images = null;

    /**
     * Image de la pochette du jeu
     */
    #[ORM\Column(nullable: true)]
    #[ApiProperty(description: "Image principale (pochette) du jeu")]
    #[Groups([
        'serialization:game:read',
        'deserialization:game:create',
        'deserialization:game:update'
    ])]
    private ?string $pochette = null;

    #[ORM\Column(nullable: true)]
    #[ApiProperty(
        security: "is_granted('ROLE_ADMIN')",
        securityPostDenormalize: "is_granted('ROLE_ADMIN')",
        description: "Indique si le jeu a été validé par un administrateur",
    )]
    #[Groups(["deserialization:game:update","deserialization:game:create","serialization:game:read"])]
    private ?bool $approved = null;

    #[ORM\OneToMany(targetEntity: Critic::class, mappedBy: 'game')]
    #[Groups(['deserialization:user:update'])]
    private Collection $critics;

    public function __construct()
    {
        $this->critics = new ArrayCollection();
    }

    public function getCritics(): ?Collection
    {
        return $this->critics;
    }

    public function setCritics(Collection $critics): static
    {
        $this->critics = $critics;

        return $this;
    }

    public function addCritic(Critic $critic): static
    {
        if (!$this->critics->contains($critic)) {
            $this->critics->add($critic);
            $critic->setGame($this);
        }

        return $this;
    }

    public function removeCritic(Critic $critic): static
    {
        if ($this->critics->removeElement($critic)) {
            // set the owning side to null (unless already changed)
            if ($critic->getAuthor() === $this) {
                $critic->setAuthor(null);
            }
        }

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

    public function setAvgNote(?float $avgNote): static
    {
        $this->avgNote = $avgNote;
        return $this;
    }

    public function setPochette(string $pochette): static
    {
        $this->pochette = $pochette;
        return $this;
    }

    public function isApprouved(): bool
    {
        return $this->approved;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getDevelopper(): ?string
    {
        return $this->developper;
    }

    public function setDevelopper(string $developper): self
    {
        $this->developper = $developper;

        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(?string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getAvgNote(): ?float
    {
        return $this->avgNote;
    }

    public function getGameMode(): ?string
    {
        return $this->gameMode;
    }

    public function setGameMode(string $gameMode): self
    {
        $this->gameMode = $gameMode;

        return $this;
    }

    public function getTargetAge(): ?int
    {
        return $this->targetAge;
    }

    public function setTargetAge(int $targetAge): self
    {
        $this->targetAge = $targetAge;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getLicence(): ?string
    {
        return $this->licence;
    }

    public function setLicence(?string $licence): self
    {
        $this->licence = $licence;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return list<string>|null
     */
    public function getPlateform(): ?array
    {
        return $this->plateform;
    }

    /**
     * @param list<string> $plateform
     */
    public function setPlateform(array $plateform): self
    {
        $this->plateform = $plateform;

        return $this;
    }

    /**
     * @return list<string>|null
     */
    public function getImages(): ?array
    {
        return $this->images;
    }

    /**
     * @param list<string> $images
     */
    public function setImages(array $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getPochette(): ?string
    {
        return $this->pochette;
    }

    public function isApproved(): ?bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }

}
