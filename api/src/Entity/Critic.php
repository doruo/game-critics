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
use ApiPlatform\Metadata\Delete;

/**
 * Critic of a game.
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
#[ORM\Entity(repositoryClass: CriticRepository::class)]
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
    private ?DateTime $date = null;

    #[ORM\ManyToOne(inversedBy: 'critics')]
    #[ORM\JoinColumn(nullable: false)]
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
}
