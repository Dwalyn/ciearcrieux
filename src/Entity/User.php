<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface, \Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    protected ?string $id = null;

    #[ORM\Column(type: Types::STRING, length: 180, nullable: false)]
    private string $email;

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

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $firstname;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $lastname;

    #[ORM\Column(type: Types::STRING, length: 8, nullable: true)]
    private ?string $licenseNumber;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTime $birthday;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $enable;

    /**
     * @param list<string> $roles,
     */
    public function __construct(
        string $firstname,
        string $lastname,
        string $email,
        \DateTime $birthday,
        ?string $licenseNumber,
        array $roles = ['ROLE_USER'],
        bool $enable = true
    ) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->birthday = $birthday;
        $this->licenseNumber = $licenseNumber;
        $this->roles = $roles;
        $this->enable = $enable;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        /**
         * @var non-empty-string $email
         */
        $email = $this->email;

        return $email;
    }

    /**
     * @see UserInterface
     *
     * @return non-empty-array<int<0, max>, string>
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

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getBirthday(): \DateTime
    {
        return $this->birthday;
    }

    public function setLicenseNumber(?string $licenseNumber): void
    {
        $this->licenseNumber = $licenseNumber;
    }

    public function getLicenseNumber(): ?string
    {
        return $this->licenseNumber;
    }

    public function setEnable(bool $enable): void
    {
        $this->enable = $enable;
    }

    public function isEnable(): bool
    {
        return $this->enable;
    }

    public function __toString(): string
    {
        return sprintf('%s %s', ucfirst($this->lastname), ucfirst($this->firstname));
    }
}
