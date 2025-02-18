<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'training_place'), ORM\Entity]
class TrainingPlace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    protected ?string $id = null;

    #[ORM\Column(type: Types::STRING, length: 50)]
    protected readonly string $name;

    #[ORM\Column(type: Types::STRING, length: 50)]
    protected readonly string $city;

    #[ORM\Column(type: Types::INTEGER)]
    protected readonly int $cityNumber;

    #[ORM\Column(type: Types::STRING, length: 100)]
    protected readonly string $adress;

    #[ORM\Column(type: Types::STRING, length: 500)]
    protected readonly string $googleMapUrl;

    public function __construct(string $name, string $adress, string $city, int $cityNumber, string $googleMapUrl)
    {
        $this->name = $name;
        $this->adress = $adress;
        $this->city = $city;
        $this->cityNumber = $cityNumber;
        $this->googleMapUrl = $googleMapUrl;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAdress(): string
    {
        return $this->adress;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCityNumber(): int
    {
        return $this->cityNumber;
    }

    public function getGoogleMapUrl(): string
    {
        return $this->googleMapUrl;
    }
}
