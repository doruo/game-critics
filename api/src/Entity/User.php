<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('login', message : "Un utilisateur ayant ce login existe déjà.")]
#[UniqueEntity('adresseEmail', message : "Cette adresse mail est déjà utilisé par un utilisateur.")]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_LOGIN', fields: ['login'])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['adresseEmail'])]
#[ApiResource(operations: [
    new Get(),
    new Delete(),
    new Post(denormalizationContext: ["groups" => ["deserialization:user:create"]]),
    new Patch(denormalizationContext: ["groups" => ["deserialization:user:update"]]),
    new Put(denormalizationContext: ["groups" => ["deserialization:user:update"]]
    ),
]
)]
class User implements UserInterface//, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(description: 'login',writable: false)]
    private ?int $id;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 4, max: 20, minMessage: 'Le login doit faire au minimum 4 caractères', maxMessage: 'Le login doit faire au maximum 20 caractères')]
    #[ApiProperty(description: 'login')]
    #[Groups(['deserialization:user:create'])]
    private ?string $login = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[ApiProperty(description: 'roles', readable: false, writable: false)]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    /*#[ORM\Column]
    private ?string $password = null;
    */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Email(message: "Le format d'email n'est pas valide")]
    #[ApiProperty(description: 'adresseEmail de l\'utilisateur ')]
    #[Groups(['deserialization:user:create', 'deserialization:user:update'])]
    private ?string $adresseEmail = null;

    /**
     * @var Collection<int, Game>
     */
    #[ORM\ManyToMany(targetEntity: Game::class)]
    #[Groups(['deserialization:user:create', 'deserialization:user:update'])]
    private Collection $favoritesGames;

    /**
     * @var Collection<int, Critic>
     */
    #[ORM\ManyToMany(targetEntity: Critic::class)]
    #[Groups(['deserialization:user:create', 'deserialization:user:update'])]
    private Collection $favoritesCritics;

    /**
     * @var Collection<int, Critic>
     */
    #[ORM\OneToMany(targetEntity: Critic::class, mappedBy: 'author')]
    #[Groups(['deserialization:user:create', 'deserialization:user:update'])]
    private Collection $critics;


    public function __construct()
    {
        $this->favoritesGames = new ArrayCollection();
        $this->favoritesCritics = new ArrayCollection();
        $this->critics = new ArrayCollection();
    }


    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function getAdresseEmail(): ?string
    {
        return $this->adresseEmail;
    }

    public function setAdresseEmail(string $email): static
    {
        $this->adresseEmail = $email;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getFavoritesGames(): Collection
    {
        return $this->favoritesGames;
    }

    public function addFavoritesGame(Game $favoritesGame): static
    {
        if (!$this->favoritesGames->contains($favoritesGame)) {
            $this->favoritesGames->add($favoritesGame);
        }

        return $this;
    }

    public function removeFavoritesGame(Game $favoritesGame): static
    {
        $this->favoritesGames->removeElement($favoritesGame);

        return $this;
    }

    /**
     * @return Collection<int, Critic>
     */
    public function getFavoritesCritics(): Collection
    {
        return $this->favoritesCritics;
    }

    public function addFavoritesCritic(Critic $favoritesCritic): static
    {
        if (!$this->favoritesCritics->contains($favoritesCritic)) {
            $this->favoritesCritics->add($favoritesCritic);
        }

        return $this;
    }

    public function removeFavoritesCritic(Critic $favoritesCritic): static
    {
        $this->favoritesCritics->removeElement($favoritesCritic);

        return $this;
    }

    public function getCritics(): ?Critic
    {
        return $this->critics;
    }

    public function setCritics(Critic $critics): static
    {
        $this->critics = $critics;

        return $this;
    }

    public function addCritic(Critic $critic): static
    {
        if (!$this->critics->contains($critic)) {
            $this->critics->add($critic);
            $critic->setAuthor($this);
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
}
