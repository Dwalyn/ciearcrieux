<?php

namespace App\Command\User;

use App\Command\CommandInterface;
use App\Entity\User;

class AddUserCommand implements CommandInterface
{
    public User $userReturn;

    /**
     * @param list<string> $roles,
     */
    public function __construct(
        public string $firstname,
        public string $lastname,
        public string $email,
        public \DateTime $birthday,
        public string $password,
        public array $roles = ['ROLE_USER'],
        public bool $enable = true,
    ) {
    }
}
