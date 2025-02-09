<?php
namespace App\Test\Controller;

use App\Tests\WebTestCase;

class LicenseControllerTest extends WebTestCase
{
    protected function getDataFolders(): array
    {
        return ['base'];
    }

    public function testPage(): void{
        $crawler = $this->client->request('GET', '/license');
        $this->assertStatusCode(200);
    }
}
