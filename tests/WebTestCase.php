<?php

namespace App\Tests;

use App\Repository\UserRepository;
use App\Tests\Service\FixturesLoader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\BrowserKit\Exception\LogicException;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class WebTestCase extends BaseWebTestCase
{
    protected ?KernelBrowser $client = null;

    private ?Router $router;

    private static bool $fixturesLoaded = false;

    private FixturesLoader $fixturesLoader;

    private ?EntityManagerInterface $entityManager = null;

    protected TranslatorInterface $translator;

    /**
     * @return string[]
     */
    protected function getGroupsForFixturesToLoad(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    abstract protected function getDataFolders(): array;

    public function setUp(): void
    {
        parent::setUp();

        if (!$this->client) {
            $this->client = static::createClient();
        } else {
            static::bootKernel();
        }

        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $this->router = static::getContainer()->get(RouterInterface::class);
        $this->translator = static::getContainer()->get(TranslatorInterface::class);

        if (!static::$fixturesLoaded) {
            $groups = $this->getGroupsForFixturesToLoad();
            $dataFolders = $this->getDataFolders();
            $first = true;
            foreach ($dataFolders as $dataFolder) {
                $cache = static::getContainer()->get(CacheInterface::class);
                $groupCached = $cache->getItem('test.group');
                $groupCached->set($dataFolder);
                $cache->save($groupCached);
                $this->loadFixtures($groups, $first);
                $first = false;
                $this->fixturesLoader->execute();
            }
            static::$fixturesLoaded = true;
        }
    }

    public function tearDown(): void
    {
        $cache = static::getContainer()->get(CacheInterface::class);
        $cache->deleteItem('test.group');
        unset($this->client, $this->entityManager, $this->router);

        parent::tearDown();
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        static::$fixturesLoaded = false;
    }

    protected function loadFixtures(array $groups, bool $first): void
    {
        $this->fixturesLoader = static::getContainer()->get(FixturesLoader::class);
        $this->fixturesLoader->load($groups, $first);
    }

    public function generateUrl(string $name, $parameters = []): string
    {
        return $this->router->generate($name, $parameters);
    }

    public function getRepository(string $className): ObjectRepository
    {
        return $this->entityManager->getRepository($className);
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    public function getTranslation(string $key): string
    {
        return $this->translator->trans($key);
    }

    public function clearRepositoryCache(): void
    {
        $this->entityManager->clear();
    }

    public function assertStatusCode($statusCode): void
    {
        $this->assertEquals($statusCode, $this->client->getResponse()->getStatusCode());
    }

    public function followJsonRedirect(): Crawler
    {
        $response = $this->client->getResponse();
        if (302 !== $response->getStatusCode()) {
            throw new LogicException('The request was not redirected.');
        }

        $jsonContent = json_decode($response->getContent(), true);
        if (!isset($jsonContent['redirectUrl'])) {
            throw new LogicException('No redirectUrl Found.');
        }

        return $this->client->request('GET', $jsonContent['redirectUrl']);
    }

    protected function login(?string $login)
    {
        if (null !== $login) {
            $userRepository = static::getContainer()->get(UserRepository::class);
            // retrieve the test user
            $testUser = $userRepository->findOneByEmail($login);

            // simulate $testUser being logged in
            $this->client->loginUser($testUser);
        }
    }

    protected function alertTest(Crawler $crawler, string $type, string $alert)
    {
        $elements = $crawler->filter(sprintf('.alert-%s', $type));
        $this->assertEquals($alert, $elements->first()->text());
    }

    /**
     * for debug only.
     */
    protected function savePage(string $pageName = 'test'): void
    {
        $fileSystem = new Filesystem();
        $fileSystem->dumpFile(sprintf('public/%s.html', $pageName), $this->client->getCrawler()->html());
    }
}
