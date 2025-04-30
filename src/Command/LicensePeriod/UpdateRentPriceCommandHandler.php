<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandHandlerInterface;
use App\Repository\RentRepository;
use Doctrine\ORM\EntityManagerInterface;

class UpdateRentPriceCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly RentRepository $rentRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(UpdateRentPriceCommand $command): void
    {
        foreach ($command->data->getLicensePriceFormDataCollection() as $rentPrice) {
            $rent = $this->rentRepository->findOneBy(['id' => $rentPrice->id]);
            $rent?->setPrice((int) $rentPrice->price);
        }
        $this->entityManager->flush();
    }
}
