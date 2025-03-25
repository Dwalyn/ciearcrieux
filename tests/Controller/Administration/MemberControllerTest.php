<?php

namespace App\Tests\Controller\Administration;

use App\Tests\Enum\HttpStatusEnum;
use App\Tests\WebTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;

class MemberControllerTest extends WebTestCase
{
    use InteractsWithLiveComponents;

    protected function getDataFolders(): array
    {
        return ['base'];
    }

    #[DataProvider('loginProvider')]
    public function testAccessPage(?string $login, int $status)
    {
        $this->login($login);

        $this->client->request('GET', $this->generateUrl('admin_membersList'));
        $this->assertStatusCode($status);

        $this->client->request('GET', $this->generateUrl('admin_membersAdd'));
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
        $crawler = $this->client->request('GET', $this->generateUrl('admin_membersList', [
        ]));
        $this->assertStatusCode(200);

        $h1 = $crawler->filter('h1');
        $this->assertCount(1, $h1);
        $this->assertEquals($this->getTranslation('menu.members'), $h1->text());

        $button = $crawler->filter('.btn-primary');
        $this->assertCount(1, $button);
        $this->assertEquals($this->getTranslation('button.add'), $button->text());

        $table = $crawler->filter('table');
        $this->assertCount(1, $table);
        $rows = $table->filter('tr');
        $this->assertCount(4, $rows);
        $columns = $rows->first()->filter('th');
        $this->assertCount(4, $columns);
        $this->assertEquals($this->getTranslation('user.lastname'), $columns->first()->text());
        $this->assertEquals($this->getTranslation('user.email'), $columns->eq(1)->text());
        $this->assertEquals($this->getTranslation('user.license_number'), $columns->eq(2)->text());
        $this->assertEquals('', $columns->last()->text());

        $checkboxes = $table->filter('input[type="checkbox"]:checked');
        $this->assertCount(2, $checkboxes);
        $checkboxes = $table->filter('input[type="checkbox"]:not(:checked)');
        $this->assertCount(1, $checkboxes);

        $badges = $table->filter('.badge');
        $this->assertCount(1, $badges);
        $this->assertEquals($this->getTranslation('enum.role.ROLE_ADMIN'), $badges->text());
    }

    public function testPageAdd(): void
    {
        $this->login('admin@google.com');
        $crawler = $this->client->request('GET', $this->generateUrl('admin_membersAdd'));
        $this->assertStatusCode(200);

        $h1 = $crawler->filter('h1');
        $this->assertCount(1, $h1);
        $this->assertEquals($this->getTranslation('menu.members'), $h1->text());

        $h3 = $crawler->filter('h3');
        $this->assertCount(1, $h3);
        $this->assertEquals($this->getTranslation('h3.new_member'), $h3->text());

        $inputText = $crawler->filter('input[type="text"]');
        $this->assertCount(3, $inputText);

        $inputDate = $crawler->filter('input[type="date"]');
        $this->assertCount(1, $inputDate);

        $select = $crawler->filter('select');
        $this->assertCount(1, $select);
    }
}
