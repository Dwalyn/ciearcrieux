<?php

namespace App\Entity;

use App\Enum\TimeStatusEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'license_period'), ORM\Entity]
class LicensePeriod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    protected ?string $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    protected \DateTime $startDate;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    protected \DateTime $endDate;

    #[ORM\Column(type: Types::STRING, length: 8, enumType: TimeStatusEnum::class)]
    public TimeStatusEnum $status;

    /**
     * @var Collection<int, License>
     */
    #[ORM\OneToMany(targetEntity: License::class, mappedBy: 'licensePeriod')]
    protected Collection $licenses;

    /**
     * @var Collection<int, Rent>
     */
    #[ORM\OneToMany(targetEntity: Rent::class, mappedBy: 'licensePeriod')]
    protected Collection $rents;

    public function __construct(
        \DateTime $startDate,
        \DateTime $endDate,
        TimeStatusEnum $status
    ) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $status;
        $this->licenses = new ArrayCollection();
        $this->rents = new ArrayCollection();
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

    public function getStatus(): TimeStatusEnum
    {
        return $this->status;
    }

    public function setStatus(TimeStatusEnum $status): void
    {
        $this->status = $status;
    }

    /**
     * @return Collection<int, License>
     */
    public function getLicenses(): Collection
    {
        return $this->licenses;
    }

    /**
     * @return Collection<int, Rent>
     */
    public function getRents(): Collection
    {
        return $this->rents;
    }
}
