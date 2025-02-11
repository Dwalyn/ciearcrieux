<?php

namespace App\DataFixtures;

use App\Entity\TrainingPlace;

class TrainingPlaceFixtures extends AbstractFixture
{
    protected function buildEntity(array $data): TrainingPlace
    {
        return new TrainingPlace($data['name'], $data['adress'], $data['city'], $data['cityNumber'], $data['googleMapUrl']);
    }

    public static function getReferenceName(): string
    {
        return 'trainingPlace';
    }
}
