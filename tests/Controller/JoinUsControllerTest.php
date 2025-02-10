<?php

namespace App\Tests\Controller;

use App\Tests\WebTestCase;

class JoinUsControllerTest extends WebTestCase
{
    protected function getDataFolders(): array
    {
        return ['base'];
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
    }
}
