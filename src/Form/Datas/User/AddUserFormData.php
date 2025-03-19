<?php

namespace App\Form\Datas\User;

use App\Enum\RoleEnum;
use Symfony\Component\Validator\Constraints as Assert;

class AddUserFormData
{
    #[Assert\NotNull]
    public ?string $firstName = null;

    #[Assert\NotNull]
    public ?string $lastName = null;

    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[Assert\NotNull]
    public ?string $email = null;

    #[Assert\NotNull]
    public ?\DateTime $birthday = null;

    public ?string $licenseNumber = null;

    #[Assert\NotNull]
    public ?RoleEnum $role;
}
