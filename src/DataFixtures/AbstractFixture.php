<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractFixture extends Fixture
{
    public function __construct(
        protected CacheItemPoolInterface $cache,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $dataFile = sprintf('%s/%s', $this->getDir(), $this->getFilenameToParse());

        if (!file_exists($dataFile)) {
            return;
        }

        $data = Yaml::parseFile($dataFile, Yaml::PARSE_CONSTANT);

        foreach ($data as $key => $item) {
            $entity = $this->buildEntity($item);
            $manager->persist($entity);

            if (is_string($key) && $reference = static::getReferenceName()) {
                $this->addReference(sprintf('%s_%s', $reference, $key), $entity);
            }
        }

        $manager->flush();
    }

    protected function getDir(): string
    {
        return __DIR__.'/datas';
    }

    protected function getFilenameToParse(): string
    {
        return sprintf('%s.yaml', static::getReferenceName());
    }

    /**
     * @param array<string, mixed> $data
     */
    abstract protected function buildEntity(array $data): mixed;

    abstract public static function getReferenceName(): string;
}
