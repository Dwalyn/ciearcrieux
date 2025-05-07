<?php

namespace App\Entity;

use App\Enum\RentTypeEnum;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'rent'), ORM\Entity]
class Rent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    protected ?string $id = null;

    #[ORM\Column(type: Types::STRING, length: 11, enumType: RentTypeEnum::class)]
    protected readonly RentTypeEnum $type;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    protected int $price;

    #[ORM\ManyToOne(targetEntity: LicensePeriod::class, inversedBy: 'rents')]
    protected LicensePeriod $licensePeriod;

    public function __construct(
        RentTypeEnum $type,
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

    public function getType(): RentTypeEnum
    {
        return $this->type;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getLicensePeriod(): LicensePeriod
    {
        return $this->licensePeriod;
    }
}
