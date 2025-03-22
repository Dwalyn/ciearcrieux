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
    public function testUserStatus(string $email, bool $userStatus, bool $resultStatus): void
    {
        $userLogin = $this->getRepository(User::class)->findOneBy(['email' => 'admin@google.com']);
        $user = $this->getRepository(User::class)->findOneBy(['email' => $email]);
        $this->assertEquals($user->isEnable(), $userStatus);

        $testComponent = $this->createLiveComponent(
            name: 'Administration:User:UserStatus',
            data: [
                'user' => $user,
                'enable' => $resultStatus,
            ],
        );
        $testComponent->actingAs($userLogin);
        $testComponent->call('changeEnable');

        $user = $this->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($user->getUserIdentifier() === $userLogin->getUserIdentifier()) {
            $this->assertEquals($user->isEnable(), !$resultStatus);
        } else {
            $this->assertEquals($user->isEnable(), $resultStatus);
        }
    }

    public static function userStatusProvider(): \Generator
    {
        yield 'enable_user' => [
            'email' => 'test2@google.com',
            'userStatus' => false,
            'resultStatus' => true,
        ];
        yield 'disable_user' => [
            'email' => 'test@google.com',
            'userStatus' => true,
            'resultStatus' => false,
        ];
        yield 'impossible_change_status' => [
            'email' => 'admin@google.com',
            'userStatus' => true,
            'resultStatus' => false,
        ];
    }
}
