<?php

namespace App\DataFixtures;

use App\DataFixtures\trait\FixturesTrait;
use App\Entity\License;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LicenseFixtures extends AbstractFixture implements DependentFixtureInterface
{
    use FixturesTrait;

    protected function buildEntity(array $data): License
    {
        return new License($data['type'], $data['price'], $this->getReferenceLicensePeriod($data));
    }

    public static function getReferenceName(): string
    {
        return 'license';
    }

    public function getDependencies(): array
    {
        return [
            LicensePeriodFixtures::class,
        ];
    }
}
