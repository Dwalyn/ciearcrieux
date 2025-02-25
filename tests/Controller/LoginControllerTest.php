<?php

namespace App\Tests\Controller;

use App\Tests\Enum\AuthenticationStatusEnum;
use App\Tests\WebTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class LoginControllerTest extends WebTestCase
{
    protected function getDataFolders(): array
    {
        return ['base'];
    }

    public function testPage(): void
    {
        $crawler = $this->client->request('GET', $this->generateUrl('login'));
        $this->assertStatusCode(200);

        $h1 = $crawler->filter('h1');
        $this->assertCount(1, $h1);
        $this->assertEquals($this->getTranslation('menu.login'), $h1->text());

        $form = $crawler->filter('form');
        $this->assertCount(1, $form);

        $input = $crawler->filter('input');
        $this->assertCount(3, $input);

        $submit = $crawler->filter('button[type="submit"]');
        $this->assertCount(1, $submit);
    }

    #[DataProvider('loginProvider')]
    public function testLogin(string $login, string $password, AuthenticationStatusEnum $authenticationStatusEnum)
    {
        $crawler = $this->client->request('GET', $this->generateUrl('login'));
        $this->assertStatusCode(200);

        $form = $crawler->selectButton($this->getTranslation('signin.button'))->form();
        $form['_username'] = $login;
        $form['_password'] = $password;
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $title = $crawler->filter('title');

        switch ($authenticationStatusEnum) {
            case AuthenticationStatusEnum::AUTH_OK:
                $this->assertEquals(
                    $this->getTranslation('global.info.title'),
                    $title->text()
                );

                break;

            case AuthenticationStatusEnum::AUTH_NOT_OK:
                $this->assertEquals(
                    sprintf('%s - %s', $this->getTranslation('global.info.title'), $this->getTranslation('menu.login')),
                    $title->text()
                );

                $alert = $crawler->filter('.alert-danger');
                $this->assertCount(1, $alert);
                $this->assertEquals('Identifiants invalides.', $alert->text());

                break;
        }
    }

    public static function loginProvider(): \Generator
    {
        yield 'login_ok' => [
            'login' => 'test@google.com',
            'password' => 'test',
            'authenticationStatusEnum' => AuthenticationStatusEnum::AUTH_OK,
        ];

        yield 'login_not_ok' => [
            'login' => 'test2@google.com',
            'password' => 'test',
            'authenticationStatusEnum' => AuthenticationStatusEnum::AUTH_NOT_OK,
        ];

        yield 'login_not_ok_empty' => [
            'login' => '',
            'password' => '',
            'authenticationStatusEnum' => AuthenticationStatusEnum::AUTH_NOT_OK,
        ];
    }
}
