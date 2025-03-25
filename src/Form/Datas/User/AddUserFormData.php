<?php

namespace App\Form\Datas\User;

use App\Enum\RoleEnum;
use App\Validator\EmailAlreadyExists;
use Symfony\Component\Validator\Constraints as Assert;

class AddUserFormData
{
    #[Assert\NotNull(groups: ['admin', 'user'])]
    #[Assert\Regex(pattern: '/\d/', match: false, message: 'constraint.noNumberInString', groups: ['admin', 'user'])]
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
        message: 'constraint.invalidEmail',
        groups: ['admin', 'user'],
    )]
    #[Assert\NotNull(groups: ['admin', 'user'])]
    #[EmailAlreadyExists(groups: ['admin', 'user'])]
    public ?string $email = null;

    #[Assert\NotNull(groups: ['admin', 'user'])]
    public ?\DateTime $birthday = null;

    #[Assert\Length(min: 7, max: 7, groups: ['user'])]
    #[Assert\NotNull(groups: ['user'])]
    #[Assert\Regex(pattern: '[0-9]{6}[a-zA-Z]{1}')]
    public ?string $licenseNumber = null;

    #[Assert\NotNull(groups: ['admin', 'user'])]
    public ?RoleEnum $role = null;
}
