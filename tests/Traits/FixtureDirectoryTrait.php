<?php

namespace App\Tests\Traits;

trait FixtureDirectoryTrait
{
    protected function getDir(): string
    {
        return sprintf('%s/DataFixtures/datas/%s', dirname(__DIR__), $this->cache->getItem('test.group')->get());
    }
}
