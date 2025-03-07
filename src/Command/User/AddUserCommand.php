<?php

namespace App\Command\User;

use App\Command\CommandInterface;
use App\Entity\User;
use App\Enum\RoleEnum;

class AddUserCommand implements CommandInterface
{
    public User $userReturn;

    /**
     * @var list<string>,
     */
    protected array $roles;

    /**
     * @param list<RoleEnum> $roles,
     */
    public function __construct(
        public ?string $firstname,
        public ?string $lastname,
        public ?string $email,
        public ?\DateTime $birthday,
        public ?string $licenseNumber,
        array $roles,
        public bool $enable = true,
        public ?string $password = null,
    ) {
        $this->roles = array_map(function (RoleEnum $roleEnum): string {
            return $roleEnum->value;
        }, $roles);
    }

    /**
     * @return list<string> $roles,
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
}
