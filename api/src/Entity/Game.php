<?php

namespace App\Entity;

use App\Repository\GameRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GameRepository::class)]
/**
 * Criticable game object.
 */
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
    private ?string $name;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 4, max: 500, minMessage: 'Le login doit faire au minimum 4 caractères', maxMessage: 'Le login doit faire au maximum 500 caractères')]
    private ?string $description;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\DateTime]
    #[Assert\LessThanOrEqual("today", message: 'Le jeu doit être sortie')]
    private ?DateTime $releaseDate;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 4, max: 20, minMessage: '', maxMessage: '')]
    private ?string $publisher;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $developper;

    #[ORM\Column(length: 180, nullable: true)]
    private ?float $avgNote;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $gameMode;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?int $targetAge;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 3, max: 50, minMessage: 'Le login doit faire au minimum 3 caractères', maxMessage: 'Le login doit faire au maximum 50 caractères')]
    private ?string $genre;

    #[ORM\Column(length: 180, nullable: true)]
    private ?string $licence;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?int $price;

    /**
     * @var list<string>
     */
    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?array $plateform;

    /**
     * @var list<string> images and screenshots
     */
    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?array $images;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $pochette;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?bool $approved;
}
