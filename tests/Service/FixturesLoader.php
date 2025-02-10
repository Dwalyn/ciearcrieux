<?php

namespace App\Tests\Service;

use Doctrine\Bundle\FixturesBundle\Loader\SymfonyFixturesLoader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\ORM\EntityManagerInterface;

class FixturesLoader
{
    private array $fixtures = [];

    public function __construct(
        private readonly SymfonyFixturesLoader $fixturesLoader,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param array<string> $groups
     */
    public function load(array $groups, bool $first = false): void
    {
        if ($first) {
            $this->clearAll();
        }
        $this->fixtures = $this->fixturesLoader->getFixtures($groups);
    }

    public function execute(): void
    {
        $executor = new ORMExecutor($this->entityManager);
        $executor->setReferenceRepository(ReferenceRepositorySingleton::getInstance($this->entityManager));
        $executor->execute($this->fixtures, true);
    }

    protected function clearAll(): void
    {
        $this->clearDatabase($this->entityManager);
    }

    protected function clearDatabase(EntityManagerInterface $entityManager): void
    {
        $this->setForeignKeyConstraint($entityManager->getConnection(), false);

        $purger = new ORMPurger($entityManager);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $purger->purge();
        $entityManager->clear();

        $this->setForeignKeyConstraint($entityManager->getConnection(), true);
        ReferenceRepositorySingleton::clearInstance();
    }

    protected function setForeignKeyConstraint(Connection $connection, bool $state): void
    {
        if ($connection->getDriver()->getDatabasePlatform() instanceof MySQLPlatform) {
            $connection->executeQuery(sprintf('SET FOREIGN_KEY_CHECKS = %d;', $state ? 1 : 0));
        }
    }
}
