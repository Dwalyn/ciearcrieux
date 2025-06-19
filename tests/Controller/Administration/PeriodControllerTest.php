<?php

namespace App\Tests\Controller\Administration;

use App\Enum\DayEnum;
use App\Enum\LicensedTypeEnum;
use App\Enum\LicenseTypeEnum;
use App\Enum\RentTypeEnum;
use App\Tests\Enum\HttpStatusEnum;
use App\Tests\WebTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class PeriodControllerTest extends WebTestCase
{
    protected function getDataFolders(): array
    {
        return ['base'];
    }

    #[DataProvider('loginProvider')]
    public function testAccessPage(string $url, array $param, array $users)
    {
        foreach ($users as $user) {
            $this->login($user['login']);
            $this->client->request('GET', $this->generateUrl($url, $param));
            $this->assertStatusCode($user['status']);
            $this->logout();
        }
    }

    public static function loginProvider(): \Generator
    {
        yield 'admin_periodList' => [
            'url' => 'admin_periodList',
            'param' => [],
            'users' => [
                [
                    'login' => 'test@google.com',
                    'status' => HttpStatusEnum::FORBIDDEN->value,
                ], [
                    'login' => 'admin@google.com',
                    'status' => HttpStatusEnum::OK->value,
                ], [
                    'login' => null,
                    'status' => HttpStatusEnum::REDIRECT->value,
                ],
            ],
        ];
        yield 'admin_periodPriceDetails' => [
            'url' => 'admin_periodPriceDetails',
            'param' => ['id' => 1],
            'users' => [
                [
                    'login' => 'test@google.com',
                    'status' => HttpStatusEnum::FORBIDDEN->value,
                ], [
                    'login' => 'admin@google.com',
                    'status' => HttpStatusEnum::OK->value,
                ], [
                    'login' => null,
                    'status' => HttpStatusEnum::REDIRECT->value,
                ],
            ],
        ];
        yield 'admin_periodLicensePrice' => [
            'url' => 'admin_periodLicensePrice',
            'param' => ['id' => 1],
            'users' => [
                [
                    'login' => 'test@google.com',
                    'status' => HttpStatusEnum::FORBIDDEN->value,
                ], [
                    'login' => 'admin@google.com',
                    'status' => HttpStatusEnum::OK->value,
                ], [
                    'login' => null,
                    'status' => HttpStatusEnum::REDIRECT->value,
                ],
            ],
        ];
        yield 'admin_periodRentPrice' => [
            'url' => 'admin_periodRentPrice',
            'param' => ['id' => 1],
            'users' => [
                [
                    'login' => 'test@google.com',
                    'status' => HttpStatusEnum::FORBIDDEN->value,
                ], [
                    'login' => 'admin@google.com',
                    'status' => HttpStatusEnum::OK->value,
                ], [
                    'login' => null,
                    'status' => HttpStatusEnum::REDIRECT->value,
                ],
            ],
        ];
        yield 'admin_periodCreate' => [
            'url' => 'admin_periodCreate',
            'param' => [],
            'users' => [
                [
                    'login' => 'test@google.com',
                    'status' => HttpStatusEnum::FORBIDDEN->value,
                ], [
                    'login' => 'admin@google.com',
                    'status' => HttpStatusEnum::REDIRECT->value,
                ], [
                    'login' => null,
                    'status' => HttpStatusEnum::REDIRECT->value,
                ],
            ],
        ];
        yield 'admin_periodTraining' => [
            'url' => 'admin_periodTraining',
            'param' => ['id' => 1],
            'users' => [
                [
                    'login' => 'test@google.com',
                    'status' => HttpStatusEnum::FORBIDDEN->value,
                ], [
                    'login' => 'admin@google.com',
                    'status' => HttpStatusEnum::OK->value,
                ], [
                    'login' => null,
                    'status' => HttpStatusEnum::REDIRECT->value,
                ],
            ],
        ];
        yield 'admin_trainingEdit' => [
            'url' => 'admin_trainingEdit',
            'param' => ['id' => 2],
            'users' => [
                [
                    'login' => 'test@google.com',
                    'status' => HttpStatusEnum::FORBIDDEN->value,
                ], [
                    'login' => 'admin@google.com',
                    'status' => HttpStatusEnum::OK->value,
                ], [
                    'login' => null,
                    'status' => HttpStatusEnum::REDIRECT->value,
                ],
            ],
        ];
        yield 'admin_trainingDayAdd' => [
            'url' => 'admin_trainingDayAdd',
            'param' => ['id' => 2],
            'users' => [
                [
                    'login' => 'test@google.com',
                    'status' => HttpStatusEnum::FORBIDDEN->value,
                ], [
                    'login' => 'admin@google.com',
                    'status' => HttpStatusEnum::OK->value,
                ], [
                    'login' => null,
                    'status' => HttpStatusEnum::REDIRECT->value,
                ],
            ],
        ];
    }

    public function testPageList(): void
    {
        $this->login('admin@google.com');
        $crawler = $this->client->request('GET', $this->generateUrl('admin_periodList', [
        ]));
        $this->assertStatusCode(200);

        $h1 = $crawler->filter('h1');
        $this->assertCount(1, $h1);
        $this->assertEquals($this->getTranslation('menu.period'), $h1->text());

        $button = $crawler->filter('.btn-primary');
        $this->assertCount(1, $button);
        $this->assertEquals($this->getTranslation('button.nextPeriod'), $button->text());

        $table = $crawler->filter('table');
        $this->assertCount(1, $table);

        $line = $table->filter('tbody tr');

        $this->assertEquals(sprintf(
            '%s - %s',
            2023,
            2024
        ), $line->first()->filter('td')->first()->text());

        $badges = $crawler->filter('.bg-success');
        $this->assertCount(1, $badges);
        $badges = $crawler->filter('.bg-danger');
        $this->assertCount(2, $badges);

        $link = $crawler->filter('table .btn-group');
        $this->assertCount(3, $link);

        $modal = $crawler->filter('.modal-dialog');
        $this->assertCount(1, $modal);

        $btnSave = $crawler->filter('.modal-dialog .btn-success');
        $this->assertCount(1, $btnSave);

        $btnCancel = $crawler->filter('.modal-dialog .btn-outline-secondary');
        $this->assertCount(1, $btnCancel);
    }

    public function testPageDetail(): void
    {
        $this->login('admin@google.com');
        $crawler = $this->client->request('GET', $this->generateUrl('admin_periodPriceDetails', [
            'id' => 4,
        ]));
        $this->assertStatusCode(200);

        $h1 = $crawler->filter('h1');
        $this->assertCount(1, $h1);
        $this->assertEquals(sprintf('%s %s-%s', $this->getTranslation('menu.period'), 2024, 2025), $h1->text());

        $badge = $crawler->filter('.bg-success');
        $this->assertCount(1, $badge);

        $h3 = $crawler->filter('h3');
        $this->assertCount(2, $h3);

        $btn = $crawler->filter('.btn-primary');
        $this->assertCount(2, $btn);

        $table = $crawler->filter('table');
        $this->assertCount(2, $table);

        $lines = $table->first()->filter('tr');
        $this->assertCount(4, $lines);

        $columns = $table->first()->filter('th');
        $this->assertCount(2, $columns);

        $lines = $table->last()->filter('tr');
        $this->assertCount(3, $lines);

        $columns = $table->first()->filter('th');
        $this->assertCount(2, $columns);
    }

    #[DataProvider('editLicencePriceProvider')]
    public function testEditLicensePrice(array $data, int $nbErrors, int $statusCode): void
    {
        $this->login('admin@google.com');
        $crawler = $this->client->request('GET', $this->generateUrl('admin_periodLicensePrice', [
            'id' => 4,
        ]));

        $form = $crawler->filter('form')->form();
        $values = $form->getPhpValues();
        $values['edit_license_price']['licensePriceFormDataCollection'][0]['price'] = $data[LicenseTypeEnum::ADULT->value];
        $values['edit_license_price']['licensePriceFormDataCollection'][1]['price'] = $data[LicenseTypeEnum::MINOR->value];
        $values['edit_license_price']['licensePriceFormDataCollection'][2]['price'] = $data[LicenseTypeEnum::DISCOVER->value];
        $crawler = $this->client->request($form->getMethod(), $form->getUri(), $values);

        $errors = $crawler->filter('.invalid-feedback');
        $this->assertCount($nbErrors, $errors);
        $this->assertStatusCode($statusCode);

        if (0 === $nbErrors) {
            $crawler = $this->client->followRedirect();
            $this->alertTest($crawler, 'success', $this->translator->trans('alert.success.updateLicencePrice'));
        }
    }

    public static function editLicencePriceProvider(): \Generator
    {
        yield 'formEmpty' => [
            'data' => [
                LicenseTypeEnum::ADULT->value => null,
                LicenseTypeEnum::MINOR->value => null,
                LicenseTypeEnum::DISCOVER->value => null,
            ],
            'nbErrors' => 3,
            'statusCode' => HttpStatusEnum::OK->value, // no redirect if form is invalid
        ];
        yield 'formNotNumber' => [
            'data' => [
                LicenseTypeEnum::ADULT->value => 'aaa',
                LicenseTypeEnum::MINOR->value => 'aaa',
                LicenseTypeEnum::DISCOVER->value => 'aaa',
            ],
            'nbErrors' => 3,
            'statusCode' => HttpStatusEnum::OK->value, // no redirect if form is invalid
        ];
        yield 'formNegativeValue' => [
            'data' => [
                LicenseTypeEnum::ADULT->value => -1,
                LicenseTypeEnum::MINOR->value => -1,
                LicenseTypeEnum::DISCOVER->value => -1,
            ],
            'nbErrors' => 3,
            'statusCode' => HttpStatusEnum::OK->value, // no redirect if form is invalid
        ];
        yield 'formWithZeroValue' => [
            'data' => [
                LicenseTypeEnum::ADULT->value => 0,
                LicenseTypeEnum::MINOR->value => 90,
                LicenseTypeEnum::DISCOVER->value => 50,
            ],
            'nbErrors' => 1,
            'statusCode' => HttpStatusEnum::OK->value, // no redirect if form is invalid
        ];
        yield 'formOk' => [
            'data' => [
                LicenseTypeEnum::ADULT->value => 100,
                LicenseTypeEnum::MINOR->value => 90,
                LicenseTypeEnum::DISCOVER->value => 50,
            ],
            'nbErrors' => 0,
            'statusCode' => 302,
        ];
    }

    #[DataProvider('editRentPriceProvider')]
    public function testEditRentPrice(array $data, int $nbErrors, int $statusCode): void
    {
        $this->login('admin@google.com');
        $crawler = $this->client->request('GET', $this->generateUrl('admin_periodRentPrice', [
            'id' => 4,
        ]));

        $form = $crawler->filter('form')->form();
        $values = $form->getPhpValues();
        $values['edit_rent_price']['licensePriceFormDataCollection'][0]['price'] = $data[RentTypeEnum::FIRST->value];
        $values['edit_rent_price']['licensePriceFormDataCollection'][1]['price'] = $data[RentTypeEnum::OTHER->value];
        $crawler = $this->client->request($form->getMethod(), $form->getUri(), $values);

        $errors = $crawler->filter('.invalid-feedback');
        $this->assertCount($nbErrors, $errors);
        $this->assertStatusCode($statusCode);

        if (0 === $nbErrors) {
            $crawler = $this->client->followRedirect();
            $this->alertTest($crawler, 'success', $this->translator->trans('alert.success.updateRentPrice'));
        }
    }

    public static function editRentPriceProvider(): \Generator
    {
        yield 'formEmpty' => [
            'data' => [
                RentTypeEnum::FIRST->value => null,
                RentTypeEnum::OTHER->value => null,
            ],
            'nbErrors' => 2,
            'statusCode' => HttpStatusEnum::OK->value, // no redirect if form is invalid
        ];
        yield 'formNotNumber' => [
            'data' => [
                RentTypeEnum::FIRST->value => 'aaa',
                RentTypeEnum::OTHER->value => 'aaa',
            ],
            'nbErrors' => 2,
            'statusCode' => HttpStatusEnum::OK->value, // no redirect if form is invalid
        ];
        yield 'formNegativeValue' => [
            'data' => [
                RentTypeEnum::FIRST->value => -1,
                RentTypeEnum::OTHER->value => -1,
            ],
            'nbErrors' => 2,
            'statusCode' => HttpStatusEnum::OK->value, // no redirect if form is invalid
        ];
        yield 'formWithZeroValue' => [
            'data' => [
                RentTypeEnum::FIRST->value => 0,
                RentTypeEnum::OTHER->value => 0,
            ],
            'nbErrors' => 0,
            'statusCode' => HttpStatusEnum::REDIRECT->value,
        ];
        yield 'formOk' => [
            'data' => [
                RentTypeEnum::FIRST->value => 100,
                RentTypeEnum::OTHER->value => 90,
            ],
            'nbErrors' => 0,
            'statusCode' => HttpStatusEnum::REDIRECT->value,
        ];
    }

    #[DataProvider('editTrainingPeriodProvider')]
    public function testEditTrainingPeriod(array $data, int $nbErrors, int $statusCode)
    {
        $this->login('admin@google.com');
        $crawler = $this->client->request('GET', $this->generateUrl('admin_trainingEdit', [
            'id' => 2,
        ]));

        $form = $crawler->filter('form')->form();
        $values = $form->getPhpValues();
        $values['edit_training']['startDate'] = $data['startDate'];
        $values['edit_training']['endDate'] = $data['endDate'];
        $values['edit_training']['trainingPlace'] = $data['trainingPlace'];
        $values['edit_training']['listTrainingDayFormData'][0]['dayEnum'] = $data['dayEnum'];
        $values['edit_training']['listTrainingDayFormData'][0]['startTime'] = $data['startTime'];
        $values['edit_training']['listTrainingDayFormData'][0]['endTime'] = $data['endTime'];
        $values['edit_training']['listTrainingDayFormData'][0]['licensedTypeEnum'] = $data['licensedTypeEnum'];

        $crawler = $this->client->request($form->getMethod(), $form->getUri(), $values);
        $errors = $crawler->filter('.invalid-feedback');
        $this->assertCount($nbErrors, $errors);
        $this->assertStatusCode($statusCode);

        if (0 === $nbErrors) {
            $crawler = $this->client->followRedirect();
            $this->alertTest($crawler, 'success', $this->translator->trans('alert.success.updateTrainingPeriod'));
        }
    }

    public static function editTrainingPeriodProvider(): \Generator
    {
        yield 'formEmpty' => [
            'data' => [
                'startDate' => null,
                'endDate' => null,
                'trainingPlace' => 2,
                'dayEnum' => null,
                'startTime' => null,
                'endTime' => null,
                'licensedTypeEnum' => null,
            ],
            'nbErrors' => 6,
            'statusCode' => HttpStatusEnum::OK->value, // no redirect if form is invalid
        ];
        yield 'lessThanLimitStartDate' => [
            'data' => [
                'startDate' => '2023-08-31',
                'endDate' => '2024-03-31',
                'trainingPlace' => 2,
                'dayEnum' => DayEnum::DAY_3->value,
                'startTime' => '10:00',
                'endTime' => '11:00',
                'licensedTypeEnum' => LicensedTypeEnum::CONFIRMED->value,
            ],
            'nbErrors' => 1,
            'statusCode' => HttpStatusEnum::OK->value, // no redirect if form is invalid
        ];
        yield 'moreThanLimitEndDate' => [
            'data' => [
                'startDate' => '2023-10-31',
                'endDate' => '2024-09-01',
                'trainingPlace' => 2,
                'dayEnum' => DayEnum::DAY_3->value,
                'startTime' => '10:00',
                'endTime' => '11:00',
                'licensedTypeEnum' => LicensedTypeEnum::CONFIRMED->value,
            ],
            'nbErrors' => 1,
            'statusCode' => HttpStatusEnum::OK->value, // no redirect if form is invalid
        ];
        yield 'formReducePeriod' => [
            'data' => [
                'startDate' => '2023-11-03',
                'endDate' => '2024-03-29',
                'trainingPlace' => 2,
                'dayEnum' => DayEnum::DAY_3->value,
                'startTime' => '10:00',
                'endTime' => '11:00',
                'licensedTypeEnum' => LicensedTypeEnum::CONFIRMED->value,
            ],
            'nbErrors' => 0,
            'statusCode' => HttpStatusEnum::REDIRECT->value, // no redirect if form is invalid
        ];

        yield 'formExtendPeriod' => [
            'data' => [
                'startDate' => '2023-10-30',
                'endDate' => '2024-04-02',
                'trainingPlace' => 2,
                'dayEnum' => DayEnum::DAY_3->value,
                'startTime' => '10:00',
                'endTime' => '11:00',
                'licensedTypeEnum' => LicensedTypeEnum::CONFIRMED->value,
            ],
            'nbErrors' => 0,
            'statusCode' => HttpStatusEnum::REDIRECT->value, // no redirect if form is invalid
        ];
        yield 'formStartTimeGreaterThanEndTimePeriod' => [
            'data' => [
                'startDate' => '2023-10-30',
                'endDate' => '2024-04-02',
                'trainingPlace' => 2,
                'dayEnum' => DayEnum::DAY_3->value,
                'startTime' => '12:00',
                'endTime' => '11:00',
                'licensedTypeEnum' => LicensedTypeEnum::CONFIRMED->value,
            ],
            'nbErrors' => 2,
            'statusCode' => HttpStatusEnum::OK->value, // no redirect if form is invalid
        ];
    }

    #[DataProvider('removeTrainingDayProvider')]
    public function testRemoveTrainingDay(array $data, string $message, int $statusCode)
    {
        $this->login('admin@google.com');
        $crawler = $this->client->request('GET', $this->generateUrl('admin_trainingDayRemove', [
            'id' => $data['id'],
        ]));

        $this->assertStatusCode($statusCode);
        $crawler = $this->client->followRedirect();

        $alert = $crawler->filter('.alert');
        $this->assertEquals($this->getTranslation($message), $alert->text());
    }

    public static function removeTrainingDayProvider(): \Generator
    {
        yield 'removeTrainingDay' => [
            'data' => [
                'id' => 22,
            ],
            'message' => 'alert.success.removeTrainingDay',
            'statusCode' => HttpStatusEnum::REDIRECT->value,
        ];
        yield 'impossibleRemoveTrainingDay' => [
            'data' => [
                'id' => 23,
            ],
            'message' => 'alert.danger.impossibleRemoveTrainingDay',
            'statusCode' => HttpStatusEnum::REDIRECT->value,
        ];
    }

    #[DataProvider('addTrainingDayProvider')]
    public function testAddRemoveTrainingDay(array $data, int $nbErrors, int $statusCode)
    {
        $this->login('admin@google.com');
        $crawler = $this->client->request('GET', $this->generateUrl('admin_trainingDayAdd', [
            'id' => 1,
        ]));

        $form = $crawler->filter('form')->form();
        $values = $form->getPhpValues();
        $values['edit_training_day_form']['dayEnum'] = $data['dayEnum'];
        $values['edit_training_day_form']['startTime'] = $data['startTime'];
        $values['edit_training_day_form']['endTime'] = $data['endTime'];
        $values['edit_training_day_form']['licensedTypeEnum'] = $data['licensedTypeEnum'];
        $crawler = $this->client->request($form->getMethod(), $form->getUri(), $values);

        $errors = $crawler->filter('.invalid-feedback');
        $this->assertCount($nbErrors, $errors);

        $this->assertStatusCode($statusCode);

        if (0 === $nbErrors) {
            $crawler = $this->client->followRedirect();
            $this->alertTest($crawler, 'success', $this->translator->trans('alert.success.addDay'));
        }
    }

    public static function addTrainingDayProvider(): \Generator
    {
        yield 'formEmpty' => [
            'data' => [
                'dayEnum' => null,
                'startTime' => null,
                'endTime' => null,
                'licensedTypeEnum' => null,
            ],
            'nbErrors' => 4,
            'statusCode' => HttpStatusEnum::OK->value,
        ];
        yield 'formStartTimeGreaterThanEndTimePeriod' => [
            'data' => [
                'dayEnum' => DayEnum::DAY_1->value,
                'startTime' => '12:00',
                'endTime' => '11:00',
                'licensedTypeEnum' => LicensedTypeEnum::CONFIRMED->value,
            ],
            'nbErrors' => 2,
            'statusCode' => HttpStatusEnum::OK->value,
        ];
        yield 'formOk' => [
            'data' => [
                'dayEnum' => DayEnum::DAY_1->value,
                'startTime' => '10:00',
                'endTime' => '11:00',
                'licensedTypeEnum' => LicensedTypeEnum::CONFIRMED->value,
            ],
            'nbErrors' => 0,
            'statusCode' => HttpStatusEnum::REDIRECT->value,
        ];
    }
}
