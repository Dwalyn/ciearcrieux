<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandHandlerInterface;
use App\Repository\LicenseRepository;
use Doctrine\ORM\EntityManagerInterface;

class UpdateLicensePriceCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly LicenseRepository $licenseRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(UpdateLicensePriceCommand $command): void
    {
        foreach ($command->data->getLicensePriceFormDataCollection() as $licencePrice) {
            $license = $this->licenseRepository->findOneBy(['id' => $licencePrice->id]);
            $license?->setPrice((int) $licencePrice->price);
        }
        $this->entityManager->flush();
    }
}
