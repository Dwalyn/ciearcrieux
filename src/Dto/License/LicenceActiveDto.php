<?php

namespace App\Dto\License;

use App\Enum\LicenseTypeEnum;

class LicenceActiveDto
{
    public readonly string $startYear;
    public readonly string $endYear;

    /**
     * @var array<int, string>
     */
    protected array $details; // liste de label de Entity/LicenseDetail

    public function __construct(
        \DateTime $startDate,
        \DateTime $endDate,
        public readonly LicenseTypeEnum $type,
        public readonly int $price,
    ) {
        $this->startYear = $startDate->format('Y');
        $this->endYear = $endDate->format('Y');
        $this->details = [];
    }

    public function addDetail(string $detail): void
    {
        $this->details[] = $detail;
    }

    /**
     * @return array<int, string> $details
     */
    public function getDetails(): array
    {
        return $this->details;
    }
}
