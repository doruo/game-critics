<?php

namespace App\Entity;
use App\Repository\GameRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;

/**
 * Criticable game object.
 */
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete(),
    ]
)]
#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 4, max: 40, minMessage: 'Le nom doit faire au minimum 4 caractères', maxMessage: 'Le nom doit faire au maximum 40 caractères')]
    private ?string $name = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 4, max: 500, minMessage: 'La description doit faire au minimum 4 caractères', maxMessage: 'La description doit faire au maximum 500 caractères')]
    private ?string $description = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\DateTime]
    #[Assert\LessThanOrEqual(value: "today", message: 'Le jeu doit être sortie')]
    private ?DateTime $releaseDate = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 1, max: 60, minMessage: 'Le nom du studio de développement doit faire au minimum 1 caractère', maxMessage: 'Le nom du studio de développement doit faire au maximum 60 caractères')]
    private ?string $developper = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 1, max: 60, minMessage: 'Le nom de l\'éditeur doit faire au minimum 1 caractère', maxMessage: 'Le nom de l\'éditeur doit faire au maximum 60 caractères')]
    private ?string $publisher = null;

    #[ORM\Column(length: 180, nullable: true)]
    private ?float $avgNote = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $gameMode = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?int $targetAge = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 3, max: 50, minMessage: 'Le genre doit faire au minimum 3 caractères', maxMessage: 'Le genre doit faire au maximum 50 caractères')]
    private ?string $genre = null;

    #[ORM\Column(length: 180, nullable: true)]
    #[Assert\Length(min: 3, max: 50, minMessage: 'La licence doit faire au minimum 3 caractères', maxMessage: 'La licence doit faire au maximum 50 caractères')]
    private ?string $licence = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?float $price = null;

    /**
     * @var list<string>
     */
    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?array $plateform = null;

    /**
     * @var list<string> images and screenshots
     */
    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?array $images = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    /**
     * Image path of the pochette
     */
    private ?string $pochette = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?bool $approved = null;
}
