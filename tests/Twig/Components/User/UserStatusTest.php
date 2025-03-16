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
    public function testUserStatus(string $email, bool $userStatus, bool $userStatusAfter): void
    {
        $this->login('admin@google.com');
        $user = $this->getRepository(User::class)->findOneBy(['email' => $email]);
        $this->assertEquals($user->isEnable(), $userStatus);

        $testComponent = $this->createLiveComponent(
            name: 'Administration:User:UserStatus',
            data: ['user' => $user, 'enable' => $userStatusAfter],
        );

        $testComponent->call('changeEnable');
        $user = $this->getRepository(User::class)->findOneBy(['email' => $email]);
        $this->assertEquals($user->isEnable(), $userStatusAfter);
    }

    public static function userStatusProvider(): \Generator
    {
        yield 'enable_user' => [
            'email' => 'test2@google.com',
            'userStatus' => false,
            'userStatusAfter' => true,
        ];
        yield 'disable_user' => [
            'email' => 'test@google.com',
            'userStatus' => true,
            'userStatusAfter' => false,
        ];
    }
}
