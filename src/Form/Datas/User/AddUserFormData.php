<?php

namespace App\Form\Datas\User;

use App\Enum\RoleEnum;
use Symfony\Component\Validator\Constraints as Assert;

class AddUserFormData
{
    #[Assert\NotNull(groups: ['admin', 'user'])]
    #[Assert\Regex(
        pattern: '/\d/',
        match: false,
        message: 'constraint.noNumberInString',
        groups: ['admin', 'user']
    )]
    public ?string $firstName = null;

    #[Assert\NotNull(groups: ['admin', 'user'])]
    #[Assert\Regex(
        pattern: '/\d/',
        match: false,
        message: 'constraint.noNumberInString',
        groups: ['admin', 'user']
    )]
    public ?string $lastName = null;

    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
        groups: ['admin', 'user'],
    )]
    #[Assert\NotNull(groups: ['admin', 'user'])]
    public ?string $email = null;

    #[Assert\NotNull(groups: ['admin', 'user'])]
    public ?\DateTime $birthday = null;

    #[Assert\Length(min: 7, max: 7, groups: ['user'])]
    #[Assert\NotNull(groups: ['user'])]
    public ?string $licenseNumber = null;

    #[Assert\NotNull(groups: ['admin', 'user'])]
    public ?RoleEnum $role = null;
}
