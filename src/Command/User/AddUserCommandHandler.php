<?php

namespace App\Command\User;

use App\Command\CommandHandlerInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AddUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(AddUserCommand $addUserCommand): void
    {
        $user = new User(
            $addUserCommand->firstname,
            $addUserCommand->lastname,
            $addUserCommand->email,
            $addUserCommand->roles,
        );

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $addUserCommand->password
        );
        $user->setPassword($hashedPassword);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $addUserCommand->userReturn = $user;
    }
}
