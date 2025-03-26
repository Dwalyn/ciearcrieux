<?php

namespace App\Tests\Controller\Administration;

use App\Tests\Enum\HttpStatusEnum;
use App\Tests\WebTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class LicensePeriodControllerTest extends WebTestCase
{
    protected function getDataFolders(): array
    {
        return ['base'];
    }

    #[DataProvider('loginProvider')]
    public function testAccessPage(?string $login, int $status)
    {
        $this->login($login);

        $this->client->request('GET', $this->generateUrl('admin_licensePeriodList'));
        $this->assertStatusCode($status);
    }

    public static function loginProvider(): \Generator
    {
        yield 'user' => [
            'login' => 'test@google.com',
            'status' => HttpStatusEnum::FORBIDDEN->value,
        ];

        yield 'admin' => [
            'login' => 'admin@google.com',
            'status' => HttpStatusEnum::OK->value,
        ];

        yield 'anonymous' => [
            'login' => null,
            'status' => HttpStatusEnum::REDIRECT->value,
        ];
    }

    public function testPageList(): void
    {
        $this->login('admin@google.com');
        $crawler = $this->client->request('GET', $this->generateUrl('admin_licensePeriodList', [
        ]));
        $this->assertStatusCode(200);

        $h1 = $crawler->filter('h1');
        $this->assertCount(1, $h1);
        $this->assertEquals($this->getTranslation('menu.period'), $h1->text());

        $button = $crawler->filter('.btn-primary');
        $this->assertCount(1, $button);
        $this->assertEquals($this->getTranslation('button.add'), $button->text());

        $card = $crawler->filter('.card');
        $this->assertCount(3, $card);

        $cardTitle = $card->first()->filter('.card-title');
        $this->assertEquals(sprintf(
            '%s - %s',
            (new \DateTime())->modify('-1 year')->format('Y'),
            (new \DateTime())->format('Y'),
        ), $cardTitle->text());

        $badges = $crawler->filter('.bg-success');
        $this->assertCount(1, $badges);
        $badges = $crawler->filter('.bg-danger');
        $this->assertCount(2, $badges);

        $link = $crawler->filter('.stretched-link');
        $this->assertCount(3, $link);
    }
}
