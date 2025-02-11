<?php

namespace App\DataFixtures;

use App\DataFixtures\trait\FixturesTrait;
use App\Entity\TrainingPeriod;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TrainingPeriodFixtures extends AbstractFixture implements DependentFixtureInterface
{
    use FixturesTrait;

    protected function buildEntity(array $data): TrainingPeriod
    {
        return new TrainingPeriod(
            new \DateTime($data['startDate']),
            new \DateTime($data['endDate']),
            $data['trainingSeason'],
            $this->getReferenceTrainingPlace($data)
        );
    }

    public static function getReferenceName(): string
    {
        return 'trainingPeriod';
    }

    public function getDependencies(): array
    {
        return [
            TrainingPlaceFixtures::class,
        ];
    }
}
