<?php

namespace App\Entity;

use App\Enum\TypePlaceEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'training_period'), ORM\Entity]
class TrainingPeriod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    protected ?string $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    protected \DateTime $startDate;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    protected \DateTime $endDate;

    #[ORM\Column(type: Types::STRING, length: 7, enumType: TypePlaceEnum::class)]
    protected readonly TypePlaceEnum $typePlaceEnum;

    /**
     * @var Collection<int, TrainingDay>
     */
    #[ORM\OneToMany(targetEntity: TrainingDay::class, mappedBy: 'trainingPeriod')]
    protected Collection $trainingDays;

    #[ORM\ManyToOne(targetEntity: TrainingPlace::class)]
    protected TrainingPlace $trainingPlace;

    #[ORM\ManyToOne(targetEntity: LicensePeriod::class)]
    protected LicensePeriod $licensePeriod;

    public function __construct(
        \DateTime $startDate,
        \DateTime $endDate,
        TypePlaceEnum $typePlaceEnum,
        TrainingPlace $trainingPlace,
        LicensePeriod $licensePeriod,
    ) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->typePlaceEnum = $typePlaceEnum;
        $this->trainingPlace = $trainingPlace;
        $this->licensePeriod = $licensePeriod;
        $this->trainingDays = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    public function getTrainingPlace(): TrainingPlace
    {
        return $this->trainingPlace;
    }

    /**
     * @return Collection<int, TrainingDay>
     */
    public function getTrainingDays(): Collection
    {
        return $this->trainingDays;
    }

    public function getTypePlaceEnum(): TypePlaceEnum
    {
        return $this->typePlaceEnum;
    }

    public function getLicensePeriod(): LicensePeriod
    {
        return $this->licensePeriod;
    }
}
