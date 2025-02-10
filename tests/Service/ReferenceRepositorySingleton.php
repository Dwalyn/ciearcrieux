<?php

namespace App\Tests\Service;

use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\Persistence\ObjectManager;

class ReferenceRepositorySingleton
{
    private static ?ReferenceRepository $_instance = null;

    public static function getInstance(ObjectManager $manager): ReferenceRepository
    {
        if (null === self::$_instance) {
            self::$_instance = new ReferenceRepository($manager);
        }

        return self::$_instance;
    }

    public static function clearInstance(): void
    {
        self::$_instance = null;
    }
}
