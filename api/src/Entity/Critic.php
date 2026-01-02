<?php

namespace App\Entity;

use App\Repository\CriticRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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
        new GetCollection(),
        new GetCollection(
            uriTemplate: '/games/{id}/critics',
            uriVariables: [
                'idGroupe' => new Link(
                    fromProperty: 'crtics',
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
    order: ["publicationDate" => "DESC"],
    normalizationContext: ["groups" => ["serialization:critic:read", "serialization:user:read", "serialization:game:read"]],
)]
#[ORM\Entity(repositoryClass: CriticRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Critic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 20, max: 500, minMessage: 'Le message général doit faire au minimum 20 caractères', maxMessage: 'Le message général doit faire au maximum 500 caractères')]
    private ?string $generalMessage = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 20, max: 500, minMessage: 'La critique des graphismes doit faire au minimum 20 caractères', maxMessage: 'La critique des graphismes doit faire au maximum 500 caractères')]
    private ?string $visualMessage = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 20, max: 500, minMessage: 'La critique de la musique doit faire au minimum 20 caractères', maxMessage: 'La critique de la musique doit faire au maximum 500 caractères')]
    private ?string $soundtrackMessage = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 20, max: 500, minMessage: 'La critique du scénario doit faire au minimum 20 caractères', maxMessage: 'La critique du scénario doit faire au maximum 500 caractères')]
    private ?string $scenarioMessage = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?Game $game = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?User $author = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?DateTime $publicationDate = null;

    #[ORM\PrePersist]
    public function prePersistDatePublication() : void {
        $this->publicationDate = new \DateTime();
    }
}
