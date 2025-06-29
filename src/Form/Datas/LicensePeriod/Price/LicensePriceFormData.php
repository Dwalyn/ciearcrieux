<?php

namespace App\Form\Datas\LicensePeriod\Price;

use App\Entity\License;
use App\Enum\LicenseTypeEnum;
use Symfony\Component\Validator\Constraints as Assert;

class LicensePriceFormData
{
    public readonly ?string $id;
    public readonly LicenseTypeEnum $type;

    #[Assert\NotNull]
    #[Assert\GreaterThan(value: 0)]
    public ?int $price;

    public function __construct(License $license)
    {
        $this->id = $license->getId();
        $this->type = $license->getType();
        $this->price = $license->getPrice();
    }
}
