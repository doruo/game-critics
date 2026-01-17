<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

use App\State\GameProcessor;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Link;

use App\Entity\Critic;
use DateTime;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Criticable game object.
 * */
#[UniqueEntity('name', message : "Ce jeu existe déjà.")]
#[ORM\Entity(repositoryClass: GameRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ["groups" => ["serialization:game:read"]]),
        new GetCollection(
            normalizationContext: ["groups" => ["serialization:user:read"]],
            uriTemplate: '/games/{id}/critics',
            uriVariables: [
                'idGameCritics' => new Link(
                    fromProperty: 'critics',
                    fromClass: Critic::class
                )
            ],
        ),
        new Get(normalizationContext: ["groups" => ["serialization:game:read"]], security: "is_granted('AUTH_ADMIN',object)"),
        new Post(denormalizationContext: ["groups" => ["deserialization:game:create"]], validationContext: ["groups" => ["Default", "validation:game:create"]], processor: GameProcessor::class),

        new Patch(denormalizationContext: ["groups" => ["deserialization:game:update"]], security: "is_granted('AUTH_ADMIN',object)"),
        new Delete(security: "is_granted('AUTH_ADMIN',object)"),
    ],
    normalizationContext: ["groups" => ["serialization:game:read"]],
)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['serialization:game:read'])]
    private ?int $id;

    #[ORM\Column(length: 40)]
    #[Assert\NotBlank(groups: ["validation:game:create"])]
    #[Assert\NotNull(groups:  ["validation:game:create"])]
    #[Assert\Length(min: 4, max: 40, minMessage: 'Le nom doit faire au minimum 4 caractères', maxMessage: 'Le nom doit faire au maximum 40 caractères')]
    #[Groups(['deserialization:user:create', 'serialization:game:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 500)]
    #[Assert\Length(min: 4, max: 500, minMessage: 'La description doit faire au minimum 4 caractères', maxMessage: 'La description doit faire au maximum 500 caractères')]
    #[Groups(['deserialization:user:create', 'serialization:game:read'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\DateTime]
    #[Assert\LessThanOrEqual(value: "today", message: 'Le jeu doit être sortie')]
    #[Groups(['deserialization:user:create', 'serialization:game:read'])]
    private ?DateTime $releaseDate = null;

    #[ORM\Column(length: 60)]
    #[Assert\NotBlank(groups: ["validation:game:create"])]
    #[Assert\NotNull(groups:  ["validation:game:create"])]
    #[Assert\Length(min: 1, max: 60, minMessage: 'Le nom du studio de développement doit faire au minimum 1 caractère', maxMessage: 'Le nom du studio de développement doit faire au maximum 60 caractères')]
    #[Groups(['deserialization:user:create', 'serialization:game:read'])]
    private ?string $developper = null;

    #[ORM\Column(length: 60)]
    #[Assert\Length(min: 1, max: 60, minMessage: 'Le nom de l\'éditeur doit faire au minimum 1 caractère', maxMessage: 'Le nom de l\'éditeur doit faire au maximum 60 caractères')]
    #[Groups(['deserialization:user:create', 'serialization:game:read'])]
    private ?string $publisher = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['serialization:game:read'])]
    private ?float $avgNote = null;

    #[ORM\Column(length: 180)]
    #[Groups(['serialization:game:read'])]
    private ?string $gameMode = null;

    #[ORM\Column]
    #[Groups(['serialization:game:read'])]
    private ?int $targetAge = null;

    #[ORM\Column(length: 50)]
    #[Groups(['serialization:game:read'])]
    #[Assert\Length(min: 3, max: 50, minMessage: 'Le genre doit faire au minimum 3 caractères', maxMessage: 'Le genre doit faire au maximum 50 caractères')]
    private ?string $genre = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['serialization:game:read'])]
    #[Assert\Length(min: 3, max: 50, minMessage: 'La licence doit faire au minimum 3 caractères', maxMessage: 'La licence doit faire au maximum 50 caractères')]
    private ?string $licence = null;

    #[ORM\Column]
    #[Groups(['serialization:game:read'])]
    private ?float $price = null;

    /**
     * @var list<string>
     */
    #[ORM\Column]
    #[Groups(['serialization:game:read'])]
    private ?array $plateform = null;

    /**
     * @var list<string> images and screenshots
     */
    #[ORM\Column]
    private ?array $images = null;

    #[ORM\Column]
    /**
     * Image path of the pochette
     */
    private ?string $pochette = null;

    #[ORM\Column]
    private ?bool $approved = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function setAvgNote(float $avgNote): static
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
}
