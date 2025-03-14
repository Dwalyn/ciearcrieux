<?php

namespace App\Tests\Twig\Components\User;

use App\Tests\WebTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;

class UserSearchTest extends WebTestCase
{
    use InteractsWithLiveComponents;

    protected function getDataFolders(): array
    {
        return ['base'];
    }

    #[DataProvider('userSearchProvider')]
    public function testUserSearch(string $searchFilter, int $nbResult)
    {
        $testComponent = $this->createLiveComponent(
            name: 'Administration:User:UserSearch',
            data: ['searchFilter' => $searchFilter],
        );
        $crawler = $testComponent->render()->crawler();
        if (0 !== $nbResult) {
            $table = $crawler->filter('table');
            $this->assertCount(1, $table);

            $lines = $crawler->filter('tbody tr');
            $this->assertCount($nbResult, $lines);

            $alert = $crawler->filter('.alert');
            $this->assertCount(0, $alert);
        } else {
            $table = $crawler->filter('table');
            $this->assertCount(0, $table);

            $alert = $crawler->filter('.alert');
            $this->assertCount(1, $alert);
            $this->assertEquals($this->getTranslation('alert.secondary.nodata'), $alert->text());
        }
    }

    public static function userSearchProvider(): \Generator
    {
        yield 'all' => [
            'searchFilter' => '',
            'nbResult' => 3,
        ];
        yield 'filterUser' => [
            'searchFilter' => 'test',
            'nbResult' => 2,
        ];
        yield 'filterEmail' => [
            'searchFilter' => 'admin@google.com',
            'nbResult' => 1,
        ];
        yield 'filterLicenseNumber' => [
            'searchFilter' => 'Z',
            'nbResult' => 1,
        ];
        yield 'noResult' => [
            'searchFilter' => 'aaa',
            'nbResult' => 0,
        ];
    }
}
