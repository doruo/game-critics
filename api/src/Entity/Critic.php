<?php

namespace App\Entity;

use App\Repository\CriticRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Link;
use App\Entity\User;
use App\Entity\Game;

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
        ),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
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
    #[Groups(['serialization:critic:read'])]
    private ?int $id;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Groups(['serialization:critic:read'])]
    private ?int $note = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 20, max: 500, minMessage: 'Le message général doit faire au minimum 20 caractères', maxMessage: 'Le message général doit faire au maximum 500 caractères')]
    #[Groups(['serialization:critic:read'])]
    private ?string $generalMessage = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 20, max: 500, minMessage: 'La critique des graphismes doit faire au minimum 20 caractères', maxMessage: 'La critique des graphismes doit faire au maximum 500 caractères')]
    #[Groups(['serialization:critic:read'])]
    private ?string $visualMessage = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 20, max: 500, minMessage: 'La critique de la musique doit faire au minimum 20 caractères', maxMessage: 'La critique de la musique doit faire au maximum 500 caractères')]
    #[Groups(['serialization:critic:read'])]
    private ?string $soundtrackMessage = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 20, max: 500, minMessage: 'La critique du scénario doit faire au minimum 20 caractères', maxMessage: 'La critique du scénario doit faire au maximum 500 caractères')]
    #[Groups(['serialization:critic:read'])]
    private ?string $scenarioMessage = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Groups(['serialization:critic:read'])]
    private ?Game $game = null;


    #[ORM\ManyToOne(inversedBy: 'critics')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['serialization:critic:read'])]
    private ?User $author = null;

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Groups(['serialization:critic:read'])]
    private ?DateTime $publicationDate = null;

    #[ORM\PrePersist]
    public function prePersistDatePublication() : void {
        $this->publicationDate = new \DateTime();
    }
}
