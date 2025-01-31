<?php

namespace App\DataFixtures;

use App\Entity\LicenseDetail;

class LicenseDetailFixtures extends AbstractFixture
{
    protected function buildEntity(array $data): LicenseDetail
    {
        return new LicenseDetail($data['label']);
    }

    public static function getReferenceName(): string
    {
        return 'licenseDetail';
    }
}
