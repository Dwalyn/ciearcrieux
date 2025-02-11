<?php

namespace App\DataFixtures;

use App\DataFixtures\trait\FixturesTrait;
use App\Entity\TrainingDay;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TrainingDayFixtures extends AbstractFixture implements DependentFixtureInterface
{
    use FixturesTrait;

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

        return new TrainingDay($data['day'], $startTime, $endTime, $data['licensedType'], $this->getReferenceTrainingPeriod($data));
    }

    public static function getReferenceName(): string
    {
        return 'trainingDay';
    }

    public function getDependencies(): array
    {
        return [
            TrainingPeriodFixtures::class,
        ];
    }
}
