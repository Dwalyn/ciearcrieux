<?php

namespace App\DataFixtures;

use App\Entity\LicenseDetail;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LicenseDetailFixtures extends AbstractFixture implements DependentFixtureInterface
{
    protected function buildEntity(array $data): LicenseDetail
    {
        return new LicenseDetail($data['label']);
    }

    public function getDependencies(): array
    {
        return [
            LicenseFixtures::class,
        ];
    }

    public static function getReferenceName(): string
    {
        return 'licenseDetail';
    }
}
