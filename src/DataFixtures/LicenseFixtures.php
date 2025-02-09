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
        $license = new License($data['type'], $data['price'], $this->getReferenceLicensePeriod($data));
        foreach ($data['licenseDetails'] as $licenseDetail) {
            $license->addLicenceDetail($this->getReferenceLicenseDetail($licenseDetail));
        }

        return $license;
    }

    public static function getReferenceName(): string
    {
        return 'license';
    }

    public function getDependencies(): array
    {
        return [
            LicensePeriodFixtures::class,
            LicenseDetailFixtures::class,
        ];
    }
}
