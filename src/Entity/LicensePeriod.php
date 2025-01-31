<?php

namespace App\Entity;

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

    #[ORM\OneToMany(targetEntity: License::class, mappedBy: 'licensePeriod')]
    protected Collection $licenses;

    public function __construct(
        \DateTime $startDate,
        \DateTime $endDate,
    ) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->licenses = new ArrayCollection();
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

    public function getLicenses(): Collection
    {
        return $this->licenses;
    }
}
