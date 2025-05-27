<?php

namespace App\Form\Datas\LicensePeriod\Price;

use App\Entity\Rent;
use App\Enum\RentTypeEnum;
use Symfony\Component\Validator\Constraints as Assert;

class RentPriceFormData
{
    public readonly ?string $id;
    public readonly RentTypeEnum $type;

    #[Assert\NotNull]
    #[Assert\GreaterThanOrEqual(value: 0)]
    public ?int $price;

    public function __construct(Rent $rent)
    {
        $this->id = $rent->getId();
        $this->type = $rent->getType();
        $this->price = $rent->getPrice();
    }
}
