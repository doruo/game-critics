<?php

namespace App\Entity;

use App\Repository\CriticRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CriticRepository::class)]
/**
 * Critic of a game.
 */
class Critic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 20, max: 500, minMessage: 'Le message doit faire au minimum 20 caractères', maxMessage: 'Le login doit faire au maximum 500 caractères')]
    private ?string $generalMessage = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 20, max: 500, minMessage: 'Le message doit faire au minimum 20 caractères', maxMessage: 'Le login doit faire au maximum 500 caractères')]
    private ?string $visualMessage = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 20, max: 500, minMessage: 'Le message doit faire au minimum 20 caractères', maxMessage: 'Le login doit faire au maximum 500 caractères')]
    private ?string $soundtrackMessage = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 20, max: 500, minMessage: 'Le message doit faire au minimum 20 caractères', maxMessage: 'Le login doit faire au maximum 500 caractères')]
    private ?string $scenarioMessage = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?Game $game = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?User $creator = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?DateTime $date = null;
}
