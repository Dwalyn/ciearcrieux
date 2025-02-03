<?php

namespace App\DataFixtures;

use App\DataFixtures\trait\FixturesTrait;
use App\Entity\Rent;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RentFixtures extends AbstractFixture implements DependentFixtureInterface
{
    use FixturesTrait;

    protected function buildEntity(array $data): Rent
    {
        return new Rent($data['type'], $data['price'], $this->getReferenceLicensePeriod($data));
    }

    public static function getReferenceName(): string
    {
        return 'rent';
    }

    public function getDependencies(): array
    {
        return [
            LicensePeriodFixtures::class,
        ];
    }
}
