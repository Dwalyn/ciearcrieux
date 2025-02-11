<?php

namespace App\DataFixtures;

use App\Entity\TrainingDay;

class TrainingDayFixtures extends AbstractFixture
{
    protected function buildEntity(array $data): TrainingDay
    {
        $array = explode('h', $data['startTime']);
        $startHour = intval($array[0]);
        $startMinute = intval($array[1]);
        $startTime = (new \DateTime())->setTime($startHour, $startMinute);

        $array = explode('h', $data['endTime']);
        $startHour = intval($array[0]);
        $startMinute = intval($array[1]);
        $endTime = (new \DateTime())->setTime($startHour, $startMinute);

        return new TrainingDay($data['day'], $startTime, $endTime, $data['licensedType']);
    }

    public static function getReferenceName(): string
    {
        return 'trainingDay';
    }
}
