<?php

namespace App\Tests\Twig\Components\User;

use App\Enum\RoleEnum;
use App\Tests\WebTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;

class UserAddTest extends WebTestCase
{
    use InteractsWithLiveComponents;

    protected function getDataFolders(): array
    {
        return ['base'];
    }

    #[DataProvider('addUserProvider')]
    public function testUserAddForm(array $data, int $statusCode): void
    {
        $testComponent = $this->createLiveComponent(
            name: 'Administration:User:UserAdd',
        );

        try {
            $testComponent
                ->submitForm([
                    'add_user' => $data,
                ], 'validForm')
            ;
            $this->assertEquals($testComponent->response()->getStatusCode(), $statusCode);
        } catch (UnprocessableEntityHttpException $e) {
            $this->assertEquals($testComponent->response()->getStatusCode(), $statusCode);
        }
    }

    public static function addUserProvider(): \Generator
    {
        yield 'formEmpty' => [
            'data' => [
                'lastName' => null,
                'firstName' => null,
                'email' => null,
                'birthday' => null,
                'role' => null,
            ],
            'statusCode' => 200, // no redirect if form is invalid
        ];
        yield 'invalidMail' => [
            'data' => [
                'lastName' => 'lastNameAdmin',
                'firstName' => 'firstNameAdmin',
                'email' => 'testadmin@emailcom',
                'birthday' => (new \DateTime())->format('Y-m-d'),
                'role' => RoleEnum::ROLE_ADMIN,
            ],
            'statusCode' => 200, // no redirect if form is invalid
        ];
        yield 'emailAlreadyExists' => [
            'data' => [
                'lastName' => 'lastNameAdmin',
                'firstName' => 'firstNameAdmin',
                'email' => 'test@google.com',
                'birthday' => (new \DateTime())->format('Y-m-d'),
                'role' => RoleEnum::ROLE_ADMIN,
            ],
            'statusCode' => 200,
        ];
        yield 'okFormAdmin' => [
            'data' => [
                'lastName' => 'lastNameAdmin',
                'firstName' => 'firstNameAdmin',
                'email' => 'testadmin@email.com',
                'birthday' => (new \DateTime())->format('Y-m-d'),
                'role' => RoleEnum::ROLE_ADMIN,
            ],
            'statusCode' => 302, // redirect if form OK
        ];
        yield 'licenceEmpty' => [
            'data' => [
                'lastName' => 'lastNameUser',
                'firstName' => 'firstNameUser',
                'email' => 'testuser@email.com',
                'birthday' => (new \DateTime())->format('Y-m-d'),
                'licenseNumber' => null,
                'role' => RoleEnum::ROLE_USER,
            ],
            'statusCode' => 200, // no redirect if form is invalid
        ];
        yield 'licenceMinLengthNotOk' => [
            'data' => [
                'lastName' => 'lastNameUser',
                'firstName' => 'firstNameUser',
                'email' => 'testuser@email.com',
                'birthday' => (new \DateTime())->format('Y-m-d'),
                'licenseNumber' => '123456',
                'role' => RoleEnum::ROLE_USER,
            ],
            'statusCode' => 200, // no redirect if form is invalid
        ];
        yield 'licenceMaxLengthNotOk' => [
            'data' => [
                'lastName' => 'lastNameUser',
                'firstName' => 'firstNameUser',
                'email' => 'testuser@email.com',
                'birthday' => (new \DateTime())->format('Y-m-d'),
                'licenseNumber' => '12345678',
                'role' => RoleEnum::ROLE_USER,
            ],
            'statusCode' => 200, // no redirect if form is invalid
        ];
        yield 'numberInLastName' => [
            'data' => [
                'lastName' => 'lastNameUser1',
                'firstName' => 'firstNameUser',
                'email' => 'testuser@email.com',
                'birthday' => (new \DateTime())->format('Y-m-d'),
                'licenseNumber' => '999999A',
                'role' => RoleEnum::ROLE_USER,
            ],
            'statusCode' => 200, // no redirect if form is invalid
        ];
        yield 'numberInFirstName' => [
            'data' => [
                'lastName' => 'lastNameUser1',
                'firstName' => 'firstNameUser1',
                'email' => 'testuser@email.com',
                'birthday' => (new \DateTime())->format('Y-m-d'),
                'licenseNumber' => '999999A',
                'role' => RoleEnum::ROLE_USER,
            ],
            'statusCode' => 200, // no redirect if form is invalid
        ];
        yield 'okFormUser' => [
            'data' => [
                'lastName' => 'lastNameUser',
                'firstName' => 'firstNameUser',
                'email' => 'testuser@email.com',
                'birthday' => (new \DateTime())->format('Y-m-d'),
                'licenseNumber' => '999999A',
                'role' => RoleEnum::ROLE_USER,
            ],
            'statusCode' => 302, // no redirect if form is invalid
        ];
    }
}
