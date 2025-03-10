<?php

namespace App\Tests\Controller\Administration;

use App\Enum\RoleEnum;
use App\Tests\Enum\HttpStatusEnum;
use App\Tests\WebTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class MemberControllerTest extends WebTestCase
{
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
        $this->assertCount(4, $inputText);

        $inputDate = $crawler->filter('input[type="date"]');
        $this->assertCount(1, $inputDate);

        $select = $crawler->filter('select');
        $this->assertCount(1, $select);
    }

    #[DataProvider('addProvider')]
    public function testAddMemberForm(int $nbError, ?string $lastname, ?string $firstname, ?string $email, ?string $birthday, ?string $licenseNumber, string $role = RoleEnum::ROLE_USER->value): void
    {
        $this->login('admin@google.com');
        $crawler = $this->client->request('GET', $this->generateUrl('admin_membersAdd'));
        $this->assertStatusCode(200);

        $form = $crawler->selectButton($this->getTranslation('button.save'))->form();
        $form['add_user[lastName]'] = $lastname;
        $form['add_user[firstName]'] = $firstname;
        $form['add_user[email]'] = $email;
        $form['add_user[birthday]'] = $birthday;
        $form['add_user[licenseNumber]'] = $licenseNumber;
        $form['add_user[role]'] = $role;
        $form['add_user[_token]'] = 'csrf-token';
        $this->client->submit($form);

        if (0 === $nbError) {
            $crawler = $this->client->followRedirect();
            $this->alertTest($crawler, 'success', $this->getTranslation('alert.success.addMember'));
        } else {
            $this->assertEquals(sprintf('http://localhost%s', $this->generateUrl('admin_membersAdd')), $crawler->getUri());
        }
    }

    public static function addProvider(): \Generator
    {
        /*yield 'invalidEmail' => [
            'nbError' => 1,
            'lastname' => 'lastname',
            'firstname' => 'firstname',
            'email' => 'lastname.firstname@google',
            'birthday' => '1970-01-01',
            'licenseNumber' => '1134467A',
            'role' => RoleEnum::ROLE_USER->value,
        ];*/
        yield 'emptyform' => [
            'nbError' => 5,
            'lastname' => '',
            'firstname' => '',
            'email' => '',
            'birthday' => '',
            'licenseNumber' => '',
            'role' => RoleEnum::ROLE_USER->value,
        ];
        yield 'okform' => [
            'nbError' => 0,
            'lastname' => 'lastname',
            'firstname' => 'firstname',
            'email' => 'lastname.firstname@google.com',
            'birthday' => '1970-01-01',
            'licenseNumber' => '1134467A',
            'role' => RoleEnum::ROLE_USER->value,
        ];
    }
}
