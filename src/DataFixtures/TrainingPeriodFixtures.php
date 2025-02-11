<?php

namespace App\DataFixtures;

use App\Entity\TrainingPeriod;

class TrainingPeriodFixtures extends AbstractFixture
{
    protected function buildEntity(array $data): TrainingPeriod
    {
        return new TrainingPeriod(new \DateTime($data['startDate']), new \DateTime($data['endDate']), $data['trainingSeason']);
    }

    public static function getReferenceName(): string
    {
        return 'trainingPeriod';
    }
}
