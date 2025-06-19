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
    protected DayEnum $day;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    protected \DateTime $startTime;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    protected \DateTime $endTime;

    #[ORM\Column(type: Types::STRING, length: 9, enumType: LicensedTypeEnum::class)]
    protected LicensedTypeEnum $licensedType;

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

    public function setDay(DayEnum $day): void
    {
        $this->day = $day;
    }

    public function getStartTime(): \DateTime
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTime $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function getEndTime(): \DateTime
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTime $endTime): void
    {
        $this->endTime = $endTime;
    }

    public function getLicensedType(): LicensedTypeEnum
    {
        return $this->licensedType;
    }

    public function setLicensedType(LicensedTypeEnum $licensedType): void
    {
        $this->licensedType = $licensedType;
    }

    public function getTrainingPeriod(): TrainingPeriod
    {
        return $this->trainingPeriod;
    }
}
