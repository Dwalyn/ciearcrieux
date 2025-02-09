<?php

namespace App\Tests;

use AFTRAL\GraalMockBundle\Service\GraalUserProvider;
use App\Tests\Service\FixturesLoader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\BrowserKit\Exception\LogicException;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;
use Symfony\Contracts\Cache\CacheInterface;

abstract class WebTestCase extends BaseWebTestCase
{
    protected ?KernelBrowser $client = null;

    private ?Router $router;

    private static bool $fixturesLoaded = false;

    private FixturesLoader $fixturesLoader;

    private ?EntityManagerInterface $entityManager = null;

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
        //$fileSystem = new Filesystem();
        //$fileSystem->remove(sprintf('%s/%s/', dirname(__DIR__, 1), $_ENV['FILE_REPOSITORY']));

        parent::tearDownAfterClass();
        static::$fixturesLoaded = false;
    }

    /**
     * @param bool $withEvent Optional parameter to avoid memory leak => use if necessary only
     */
    /*public function login(string $username, bool $withEvent = false): void
    {
        $graalUserProvider = self::getContainer()->get(GraalUserProvider::class);
        $user = $graalUserProvider->findUser($username);

        $this->client->loginUser($user);

        if ($withEvent) {
            // @TODO : following code should be done in previous methode `$this->client->loginUser($user);` => check symfony/framework-bundle updates!
            $token = self::getContainer()->get(TokenStorageInterface::class)->getToken();
            self::getContainer()->get(EventDispatcherInterface::class)->dispatch(
                new AuthenticationSuccessEvent($token),
                AuthenticationEvents::AUTHENTICATION_SUCCESS
            );

            $this->client->disableReboot();
        } else {
            $this->client->enableReboot();
        }
    }*/

    /*protected function logout(): void
    {
        $this->client->request('GET', '_logout');
    }*/

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

    /**
     * for debug only.
     */
    protected function savePage(string $pageName = 'test'): void
    {
        $fileSystem = new Filesystem();
        $fileSystem->dumpFile(sprintf('public/%s.html', $pageName), $this->client->getCrawler()->html());
    }
}
