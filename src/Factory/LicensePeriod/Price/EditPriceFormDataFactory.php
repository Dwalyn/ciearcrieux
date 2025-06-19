<?php

namespace App\Factory\LicensePeriod\Price;

use App\Entity\LicensePeriod;
use App\Form\Datas\LicensePeriod\Price\EditPriceFormData;
use App\Form\Datas\LicensePeriod\Price\LicensePriceFormData;
use App\Form\Datas\LicensePeriod\Price\RentPriceFormData;
use App\Repository\LicenseRepository;
use App\Repository\RentRepository;

class EditPriceFormDataFactory
{
    public function __construct(
        private LicenseRepository $licenseRepository,
        private RentRepository $rentRepository,
    ) {
    }

    public function buildDataLicense(LicensePeriod $licensePeriod): EditPriceFormData
    {
        $formData = new EditPriceFormData();
        $licenses = $this->licenseRepository->findBy(['licensePeriod' => $licensePeriod]);

        foreach ($licenses as $license) {
            $licenseFormData = new LicensePriceFormData($license);
            $formData->addLicenseFormData($licenseFormData);
        }

        return $formData;
    }

    public function buildDataRent(LicensePeriod $licensePeriod): EditPriceFormData
    {
        $formData = new EditPriceFormData();
        $rents = $this->rentRepository->findBy(['licensePeriod' => $licensePeriod]);

        foreach ($rents as $rent) {
            $rentFormData = new RentPriceFormData($rent);
            $formData->addLicenseFormData($rentFormData);
        }

        return $formData;
    }
}
