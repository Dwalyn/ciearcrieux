<?php

namespace App\Form\Datas\LicensePeriod\Price;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class EditPriceFormData
{
    /**
     * @var ArrayCollection<int, LicensePriceFormData|RentPriceFormData>
     */
    #[Assert\Valid]
    private ArrayCollection $licensePriceFormDataCollection;

    public function __construct()
    {
        $this->licensePriceFormDataCollection = new ArrayCollection();
    }

    public function addLicenseFormData(LicensePriceFormData|RentPriceFormData $licenseFormData): void
    {
        $this->licensePriceFormDataCollection->add($licenseFormData);
    }

    /**
     * @return ArrayCollection<int, LicensePriceFormData|RentPriceFormData>
     */
    public function getLicensePriceFormDataCollection(): Collection
    {
        return $this->licensePriceFormDataCollection;
    }
}
