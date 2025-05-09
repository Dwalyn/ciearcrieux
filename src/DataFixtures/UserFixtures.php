<?php

namespace App\DataFixtures;

use App\Command\CommandBusInterface;
use App\Command\User\AddUserCommand;
use App\Entity\User;

class UserFixtures extends AbstractFixture
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    protected function buildEntity(array $data): User
    {
        $command = new AddUserCommand(
            $data['firstname'],
            $data['lastname'],
            $data['email'],
            $data['birthday'] ?? new \DateTime(),
            $data['licenseNumber'],
            $data['roles'],
            $data['enable'] ?? true,
            $data['password'],
        );
        $this->commandBus->dispatch($command);

        return $command->userReturn;
    }

    public static function getReferenceName(): string
    {
        return 'user';
    }
}
