<?php

namespace App\Factory\LicensePeriod;

use App\Entity\LicensePeriod;
use App\Form\Datas\LicensePeriod\EditPriceFormData;
use App\Form\Datas\LicensePeriod\LicensePriceFormData;
use App\Repository\LicenseRepository;

class EditPriceFormDataFactory
{
    public function __construct(
        private LicenseRepository $licenseRepository,
    ) {
    }

    public function buildData(LicensePeriod $licensePeriod): EditPriceFormData
    {
        $formData = new EditPriceFormData();
        $licenses = $this->licenseRepository->findBy(['licensePeriod' => $licensePeriod]);

        foreach ($licenses as $license) {
            $licenseFormData = new LicensePriceFormData($license);
            $formData->addLicenseFormData($licenseFormData);
        }

        return $formData;
    }
}
