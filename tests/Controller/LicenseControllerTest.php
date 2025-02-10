<?php
namespace App\Tests\Controller;

use App\Tests\WebTestCase;

class LicenseControllerTest extends WebTestCase
{
    protected function getDataFolders(): array
    {
        return ['base'];
    }

    public function testPage(): void{
        $crawler = $this->client->request('GET', '/license');
        $this->savePage();
        $this->assertStatusCode(200);
    }
}
