<?php

namespace App\Entity;

use App\Repository\CriticRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\ApiProperty;
use App\State\CriticProcessor;
use DateTime;

/**
 * Critic of a game.
 */
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/games/{id}/critics',
            uriVariables: [
                'idGameCritics' => new Link(
                    fromProperty: 'critics',
                    fromClass: Game::class
                )
            ],
            normalizationContext: ["groups" => ["serialization:critic:read"]]
        ),

        new Get(
            normalizationContext: ["groups" => ["serialization:critic:read"]]
        ),

        new Post(
            normalizationContext: ["groups" => ["serialization:critic:read"]],
            denormalizationContext: ["groups" => ["deserialization:critic:create"]],
            validationContext: ["groups" => ["Default", "validation:critic:create"]],
            processor: CriticProcessor::class
        ),

        // Only if author is connected user or admin
        new Patch(
            normalizationContext: ["groups" => ["serialization:critic:read"]],
            denormalizationContext: ["groups" => ["deserialization:critic:update"]],
            validationContext: ["groups" => ["Default", "validation:critic:update"]]
        ),

        new Delete(),
    ],
    normalizationContext: ["groups" => ["serialization:critic:read"]],
    order: ["publicationDate" => "DESC"],
)]
#[ORM\Entity(repositoryClass: CriticRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Critic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(
        description: "Id",
        readable: true,
        writable: false
    )]
    #[Groups(['serialization:critic:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[ApiProperty(description: "Note attribuée au jeu")]
    #[Assert\NotBlank(groups: ["validation:critic:create"])]
    #[Assert\NotNull(groups: ["validation:critic:create"])]
    #[Assert\Range(
        notInRangeMessage: "La note doit être comprise entre 0 et 20.",
        min: 0,
        max: 20
    )]
    #[Groups([
        'serialization:critic:read',
        'deserialization:critic:create',
        'deserialization:critic:update'
    ])]
    private ?int $note = null;

    #[ORM\Column(length: 500)]
    #[ApiProperty(description: "Avis général sur le jeu")]
    #[Assert\NotBlank(groups: ["validation:critic:create"])]
    #[Assert\Length(
        min: 20,
        max: 500,
        minMessage: "Le message général doit faire au minimum 20 caractères.",
        maxMessage: "Le message général doit faire au maximum 500 caractères."
    )]
    #[Groups([
        'serialization:critic:read',
        'deserialization:critic:create',
        'deserialization:critic:update'
    ])]
    private ?string $generalMessage = null;

    #[ORM\Column(length: 500)]
    #[ApiProperty(description: "Avis sur les graphismes")]
    #[Assert\NotBlank(groups: ["validation:critic:create"])]
    #[Assert\Length(
        min: 20,
        max: 500,
        minMessage: "La critique des graphismes doit faire au minimum 20 caractères.",
        maxMessage: "La critique des graphismes doit faire au maximum 500 caractères."
    )]
    #[Groups([
        'serialization:critic:read',
        'deserialization:critic:create',
        'deserialization:critic:update'
    ])]
    private ?string $visualMessage = null;

    #[ORM\Column(length: 500)]
    #[ApiProperty(description: "Avis sur la bande-son")]
    #[Assert\NotBlank(groups: ["validation:critic:create"])]
    #[Assert\Length(
        min: 20,
        max: 500,
        minMessage: "La critique de la musique doit faire au minimum 20 caractères.",
        maxMessage: "La critique de la musique doit faire au maximum 500 caractères."
    )]
    #[Groups([
        'serialization:critic:read',
        'deserialization:critic:create',
        'deserialization:critic:update'
    ])]
    private ?string $soundtrackMessage = null;

    #[ORM\Column(length: 500)]
    #[ApiProperty(description: "Avis sur le scénario")]
    #[Assert\NotBlank(groups: ["validation:critic:create"])]
    #[Assert\Length(
        min: 20,
        max: 500,
        minMessage: "La critique du scénario doit faire au minimum 20 caractères.",
        maxMessage: "La critique du scénario doit faire au maximum 500 caractères."
    )]
    #[Groups([
        'serialization:critic:read',
        'deserialization:critic:create',
        'deserialization:critic:update'
    ])]
    private ?string $scenarioMessage = null;

    #[ORM\ManyToOne(inversedBy: 'critics')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiProperty(description: "Jeu concerné par la critique")]
    #[Groups(['serialization:critic:read'])]
    private ?Game $game = null;

    #[ORM\ManyToOne(inversedBy: 'critics')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiProperty(description: "Auteur de la critique")]
    #[Groups(['serialization:critic:read'])]
    private ?User $author = null;

    #[ORM\Column]
    #[ApiProperty(
        description: "Date de publication de la critique",
        readable: true,
        writable: false
    )]
    #[Groups(['serialization:critic:read'])]
    private ?DateTime $publicationDate = null;

    #[ORM\PrePersist]
    public function prePersistDatePublication(): void
    {
        $this->publicationDate = new DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getGeneralMessage(): ?string
    {
        return $this->generalMessage;
    }

    public function setGeneralMessage(string $generalMessage): self
    {
        $this->generalMessage = $generalMessage;

        return $this;
    }

    public function getVisualMessage(): ?string
    {
        return $this->visualMessage;
    }

    public function setVisualMessage(string $visualMessage): self
    {
        $this->visualMessage = $visualMessage;

        return $this;
    }

    public function getSoundtrackMessage(): ?string
    {
        return $this->soundtrackMessage;
    }

    public function setSoundtrackMessage(string $soundtrackMessage): self
    {
        $this->soundtrackMessage = $soundtrackMessage;

        return $this;
    }

    public function getScenarioMessage(): ?string
    {
        return $this->scenarioMessage;
    }

    public function setScenarioMessage(string $scenarioMessage): self
    {
        $this->scenarioMessage = $scenarioMessage;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPublicationDate(): ?DateTime
    {
        return $this->publicationDate;
    }
}
