<?php

namespace App\Dto;

use App\Enum\LicenseTypeEnum;

class LicenceActiveDto
{
    public readonly string $startYear;
    public readonly string $endYear;
    public readonly LicenseTypeEnum $type;
    public readonly int $price;
    protected array $details;

    public function __construct(array $data)
    {
        $this->startYear = $data['startDate']->format('Y');
        $this->endYear = $data['endDate']->format('Y');
        $this->type = $data['type'];
        $this->price = $data['price'];
        $this->details = [];
    }

    public function addDetail(string $detail): void
    {
        $this->details[] = $detail;
    }

    public function getDetails(): array
    {
        return $this->details;
    }
}
