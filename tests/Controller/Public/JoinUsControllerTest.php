<?php

namespace App\Tests\Controller\Public;

use App\Enum\LicenseTypeEnum;
use App\Enum\RentTypeEnum;
use App\Tests\Enum\HttpStatusEnum;
use App\Tests\WebTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class JoinUsControllerTest extends WebTestCase
{
    protected function getDataFolders(): array
    {
        return ['base'];
    }

    #[DataProvider('loginProvider')]
    public function testAccessPage(?string $login, int $status)
    {
        $this->login($login);
        $crawler = $this->client->request('GET', $this->generateUrl('joinUs'));
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
        $crawler = $this->client->request('GET', $this->generateUrl('joinUs'));
        $this->assertStatusCode(200);

        $h1 = $crawler->filter('h1');
        $this->assertCount(1, $h1);
        $this->assertEquals($this->getTranslation('menu.joinUs'), $h1->text());

        $h3 = $crawler->filter('h3');
        $this->assertCount(3, $h3);
        $this->assertEquals($this->getTranslation('h3.license'), $h3->first()->text());
        $this->assertEquals($this->getTranslation('h3.documents'), $h3->eq(1)->text());
        $this->assertEquals($this->getTranslation('h3.rent'), $h3->last()->text());

        // Test license
        $licenses = $crawler->filter('.license');
        $this->assertCount(3, $licenses);

        $licenseType = $licenses->first()->filter('.licenseType');
        $this->assertCount(1, $licenseType);
        $this->assertEquals($this->translator->trans(LicenseTypeEnum::ADULT->getTranslationKey()), $licenseType->text());

        $price = $licenses->first()->filter('.price');
        $this->assertCount(1, $price);
        $this->assertEquals('120€ / an', $price->text());

        $licenseDetail = $licenses->first()->filter('.licenseDetail');
        $this->assertCount(3, $licenseDetail);

        // Test document
        $documents = $crawler->filter('.document');
        $this->assertCount(2, $documents);

        // Test rent
        $rents = $crawler->filter('.rent');
        $this->assertCount(2, $rents);

        $rentType = $rents->first()->filter('.rentType');
        $this->assertCount(1, $rentType);
        $this->assertEquals($this->translator->trans(RentTypeEnum::FIRST->getTranslationKey()), $rentType->text());

        $price = $rents->first()->filter('.price');
        $this->assertCount(1, $price);
        $this->assertEquals($this->getTranslation('license.rent.free'), $price->text());

        $rentType = $rents->last()->filter('.rentType');
        $this->assertCount(1, $rentType);
        $this->assertEquals($this->translator->trans(RentTypeEnum::OTHER->getTranslationKey()), $rentType->text());

        $price = $rents->last()->filter('.price');
        $this->assertCount(1, $price);
        $this->assertEquals('50€ / an', $price->text());
    }
}
