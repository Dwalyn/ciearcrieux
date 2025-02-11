<?php

namespace App\Entity;

use App\Enum\DayEnum;
use App\Enum\LicensedTypeEnum;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'training_day'), ORM\Entity]
class TrainingDay
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    protected ?string $id = null;

    #[ORM\Column(type: Types::INTEGER, enumType: DayEnum::class)]
    protected readonly DayEnum $day;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    protected \DateTime $startTime;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    protected \DateTime $endTime;

    #[ORM\Column(type: Types::STRING, length: 9, enumType: DayEnum::class)]
    protected readonly LicensedTypeEnum $licensedType;

    public function __construct(DayEnum $day, \DateTime $startTime, \DateTime $endTime, LicensedTypeEnum $licensedType)
    {
        $this->day = $day;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->licensedType = $licensedType;
    }
}
