<?php

namespace App\Tests\Controller\Public;

use App\Enum\TypePlaceEnum;
use App\Tests\Enum\HttpStatusEnum;
use App\Tests\WebTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class FindUsControllerTest extends WebTestCase
{
    protected function getDataFolders(): array
    {
        return ['base'];
    }

    #[DataProvider('loginProvider')]
    public function testAccessPage(?string $login, int $status)
    {
        $this->login($login);
        $this->client->request('GET', $this->generateUrl('findUs', [
            'typePlace' => TypePlaceEnum::OUTDOOR->value,
        ]));
        $this->assertStatusCode($status);
    }

    public static function loginProvider(): \Generator
    {
        yield 'User' => [
            'login' => 'test@google.com',
            'status' => HttpStatusEnum::OK->value,
        ];

        yield 'admin' => [
            'login' => 'admin@google.com',
            'status' => HttpStatusEnum::OK->value,
        ];

        yield 'anonymous' => [
            'login' => null,
            'status' => HttpStatusEnum::OK->value,
        ];
    }

    public function testPage(): void
    {
        $crawler = $this->client->request('GET', $this->generateUrl('findUs', [
            'typePlace' => TypePlaceEnum::OUTDOOR->value,
        ]));
        $this->assertStatusCode(200);

        $h1 = $crawler->filter('h1');
        $this->assertCount(1, $h1);
        $this->assertEquals($this->getTranslation('menu.findUs'), $h1->text());

        $outdoorlink = $crawler->filter('.outdoorlink');
        $this->assertCount(1, $outdoorlink);
        $indoorlink = $crawler->filter('.indoorlink');
        $this->assertCount(1, $indoorlink);

        $card = $crawler->filter('.card');
        $this->assertCount(1, $card);
        $cardTitle = $crawler->filter('.card-title');
        $this->assertCount(1, $cardTitle);
        $this->assertEquals('Compagnie d\'arc', $cardTitle->text());

        $date = $card->filter('.date');
        $this->assertCount(1, $date);

        $place = $card->filter('.place');
        $this->assertCount(1, $place);

        $planing = $card->filter('.planning');
        $this->assertCount(1, $planing);

        $day = $card->filter('.day');
        $this->assertCount(2, $day);

        $map = $card->filter('.map');
        $this->assertCount(1, $map);
    }
}
