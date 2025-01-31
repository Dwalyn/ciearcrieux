<?php

namespace App\Entity;

use App\Enum\LicenseTypeEnum;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'license'), ORM\Entity]
class License
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    protected ?string $id = null;

    #[ORM\Column(type: Types::STRING, length: 11, enumType: LicenseTypeEnum::class)]
    protected readonly LicenseTypeEnum $type;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    protected int $price;

    #[ORM\ManyToOne(targetEntity: LicensePeriod::class, inversedBy: 'licenses')]
    protected LicensePeriod $licensePeriod;

    public function __construct(
        LicenseTypeEnum $type,
        int $price,
        LicensePeriod $licensePeriod,
    ) {
        $this->type = $type;
        $this->price = $price;
        $this->licensePeriod = $licensePeriod;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getType(): LicenseTypeEnum
    {
        return $this->type;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getLicensePeriod(): LicensePeriod
    {
        return $this->licensePeriod;
    }
}
