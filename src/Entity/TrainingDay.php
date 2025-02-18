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

    #[ORM\Column(type: Types::STRING, length: 9, enumType: LicensedTypeEnum::class)]
    protected readonly LicensedTypeEnum $licensedType;

    #[ORM\ManyToOne(targetEntity: TrainingPeriod::class, inversedBy: 'trainingDays')]
    protected TrainingPeriod $trainingPeriod;

    public function __construct(DayEnum $day, \DateTime $startTime, \DateTime $endTime, LicensedTypeEnum $licensedType, TrainingPeriod $trainingPeriod)
    {
        $this->day = $day;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->licensedType = $licensedType;
        $this->trainingPeriod = $trainingPeriod;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getDay(): DayEnum
    {
        return $this->day;
    }

    public function getStartTime(): \DateTime
    {
        return $this->startTime;
    }

    public function getEndTime(): \DateTime
    {
        return $this->endTime;
    }

    public function getLicensedType(): LicensedTypeEnum
    {
        return $this->licensedType;
    }

    public function getTrainingPeriod(): TrainingPeriod
    {
        return $this->trainingPeriod;
    }
}
