<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('login', message : "Un utilisateur ayant ce login existe déjà.")]
#[UniqueEntity('adresseEmail', message : "Cette adresse mail est déjà utilisé par un utilisateur.")]
#[UniqueEntity('hashedEmail', message : "le hash de votre adresse mail est déjà utilisé par un utilisateur.")]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_LOGIN', fields: ['login'])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['adresseEmail'])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_HASHED_EMAIL', fields: ['hashedEmail'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 4, max: 20, minMessage: 'Le login doit faire au minimum 4 caractères', maxMessage: 'Le login doit faire au maximum 20 caractères')]
    private ?string $login = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Email(message: "Le format d'email n'est pas valide")]
    private ?string $adresseEmail = null;

    #[ORM\Column]
    private ?string $hashedEmail = null;

    #[ORM\Column]
    private ?bool $isPictureMasked = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profilePictureName = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    /**
     * @var list<Game> list of favorite games
     */
    private ?array $favorites;


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

    public function getHashedEmail(): ?string
    {
        if ($this->adresseEmail === null) {
            return null;
        }

        return hash('sha256', $this->adresseEmail);
    }

    public function setHashedEmail(string $email): static
    {
        $this->hashedEmail = $email;

        return $this;
    }
}
