<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'license_detail'), ORM\Entity]
class LicenseDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    protected ?string $id = null;

    #[ORM\Column(type: Types::STRING, length: 120)]
    protected string $label;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
