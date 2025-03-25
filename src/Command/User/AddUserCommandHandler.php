<?php

namespace App\Command\User;

use App\Command\CommandHandlerInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Exception\LogicException;
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
        if (is_null($addUserCommand->firstname)
            || is_null($addUserCommand->lastname)
            || is_null($addUserCommand->email)
            || is_null($addUserCommand->birthday)
        ) {
            throw new LogicException('Value can not be null.');
        }

        $user = new User(
            $addUserCommand->firstname,
            $addUserCommand->lastname,
            $addUserCommand->email,
            $addUserCommand->birthday,
            $addUserCommand->licenseNumber,
            $addUserCommand->getRoles(),
            $addUserCommand->enable,
        );
        $addUserCommand->password ??= 'ciearcrieux';

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
