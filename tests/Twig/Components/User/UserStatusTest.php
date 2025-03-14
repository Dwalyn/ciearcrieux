<?php

namespace App\Tests\Twig\Components\User;

use App\Entity\User;
use App\Tests\WebTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;

class UserStatusTest extends WebTestCase
{
    use InteractsWithLiveComponents;

    protected function getDataFolders(): array
    {
        return ['base'];
    }

    #[DataProvider('userStatusProvider')]
    public function testUserStatus(string $email, bool $baseStatus, bool $statusAction, bool $statusAfterAction): void
    {
        $this->login('admin@google.com');

        $user = $this->getRepository(User::class)->findOneBy(['email' => $email]);
        $testComponent = $this->createLiveComponent(
            name: 'Administration:User:UserStatus',
            data: ['user' => $user],
        );

        $crawler = $testComponent->render()->crawler();
        if ($baseStatus) {
            $checkbox = $crawler->filter('input[type="checkbox"]:checked');
            $this->assertCount(1, $checkbox);
            $checkbox = $crawler->filter('input[type="checkbox"]:not(:checked)');
            $this->assertCount(0, $checkbox);
        } else {
            $checkbox = $crawler->filter('input[type="checkbox"]:checked');
            $this->assertCount(0, $checkbox);
            $checkbox = $crawler->filter('input[type="checkbox"]:not(:checked)');
            $this->assertCount(1, $checkbox);
        }
        $testComponent->set('enable', $statusAction);

        if ($statusAfterAction) {
            $checkbox = $crawler->filter('input[type="checkbox"]:checked');
            $this->assertCount(1, $checkbox);
            $checkbox = $crawler->filter('input[type="checkbox"]:not(:checked)');
            $this->assertCount(0, $checkbox);
        } else {
            $checkbox = $crawler->filter('input[type="checkbox"]:checked');
            $this->assertCount(0, $checkbox);
            $checkbox = $crawler->filter('input[type="checkbox"]:not(:checked)');
            $this->assertCount(1, $checkbox);
        }
    }

    public static function userStatusProvider(): \Generator
    {
        yield 'admin' => [
            'email' => 'admin@google.com',
            'baseStatus' => true,
            'statusAction' => false,
            'statusAfterAction' => true,
        ];
        yield 'enable_user' => [
            'email' => 'test2@google.com',
            'baseStatus' => false,
            'statusAction' => true,
            'statusAfterAction' => true,
        ];
        /*yield 'disable_user' => [
            'email' => 'test@google.com',
            'baseStatus' => true,
            'statusAction' => false,
            'statusAfterAction' => false,
        ];*/
    }
}
