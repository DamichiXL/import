<?php

use DamichiXL\Import\DTOs\ImportFieldDTO;
use DamichiXL\Import\DTOs\ImportModelDTO;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    Storage::fake('local');
    User::unguard();

    config()->set('import.models', [
        'users' => ImportModelDTO::make(
            name: 'Users',
            model: User::class,
            key: 'email',
            fields: [
                ImportFieldDTO::make(name: 'id', label: 'ID'),
                ImportFieldDTO::make(name: 'name', label: 'Name'),
                ImportFieldDTO::make(name: 'email', label: 'Email'),
                ImportFieldDTO::make(name: 'password', label: 'Password'),
            ],
        ),
    ]);
});

afterEach(function () {
    User::reguard();
});

describe('Import', function () {
    describe('Validation', function () {
        describe('Model', function () {
            it('Model not found', function () {
                // @phpstan-ignore method.notFound
                $this->postJson(route('store'), [
                    'model' => 'NonExistentModel',
                ])->assertStatus(422)
                    ->assertJsonValidationErrors('model');
            });
        });

        describe('File', function () {
            it('File is required', function () {
                // @phpstan-ignore method.notFound
                $this->postJson(route('store'))
                    ->assertStatus(422)
                    ->assertJsonValidationErrors('file');
            });

            it('File must be a file', function () {
                // @phpstan-ignore method.notFound
                $this->postJson(route('store'), [
                    'file' => 'not-a-file',
                ])->assertStatus(422)
                    ->assertJsonValidationErrors('file');
            });

            it('File must be a xlsx', function () {
                // @phpstan-ignore method.notFound
                $this->postJson(route('store'), [
                    'file' => UploadedFile::fake()->create(
                        'users.php',
                        1000,
                        'application/x-httpd-php',
                    ),
                ])->assertStatus(422)
                    ->assertJsonValidationErrors('file');
            });
        });

        describe('Fields', function () {
            it('Fields are required', function () {
                // @phpstan-ignore method.notFound
                $this->postJson(route('store'), [
                    'fields' => [],
                ])->assertStatus(422)
                    ->assertJsonValidationErrors('fields');
            });

            it('Model not found', function () {
                // @phpstan-ignore method.notFound
                $this->postJson(route('store'), [
                    'model' => 'users',
                    'file' => UploadedFile::fake()->create(
                        'users.xls',
                        1000,
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ),
                    'fields' => [
                        [
                            'order' => 1,
                            'value' => 'NonExistentField',
                        ],
                    ],
                ])->assertStatus(
                    422
                )->assertJsonValidationErrors('fields.0.value');
            });
        });
    });

    describe('Data', function () {
        it('Successfully stored', function () {
            // @phpstan-ignore method.notFound
            $this->postJson(route('store'), [
                'model' => 'users',
                'file' => new UploadedFile(
                    __DIR__.'/../../assets/test.csv',
                    'test.csv',
                    'text/csv',
                    null,
                    true
                ),
                'fields' => [
                    [
                        'order' => 0,
                        'value' => 'email',
                    ],
                    [
                        'order' => 1,
                        'value' => 'name',
                    ],
                    [
                        'order' => 2,
                        'value' => 'password',
                    ],
                ],
            ])->assertOk();

            $data = getDataFromCSV(__DIR__.'/../../assets/test.csv');

            foreach ($data as $row) {
                // @phpstan-ignore method.notFound
                $this->assertDatabaseHas('users', [
                    'email' => $row[0],
                    'name' => $row[1],
                    'password' => $row[2],
                ]);
            }
        });

        it('Successfully updated', function () {
            $data = getDataFromCSV(__DIR__.'/../../assets/test.csv');

            foreach ($data as $row) {
                User::create([
                    'email' => $row[0],
                    'name' => fake()->name(),
                    'password' => fake()->password(),
                ]);
            }

            // @phpstan-ignore method.notFound
            $this->postJson(route('store'), [
                'model' => 'users',
                'file' => new UploadedFile(
                    __DIR__.'/../../assets/test.csv',
                    'test.csv',
                    'text/csv',
                    null,
                    true
                ),
                'fields' => [
                    [
                        'order' => 0,
                        'value' => 'email',
                    ],
                    [
                        'order' => 1,
                        'value' => 'name',
                    ],
                    [
                        'order' => 2,
                        'value' => 'password',
                    ],
                ],
            ])->assertOk();

            $data = getDataFromCSV(__DIR__.'/../../assets/test.csv');

            foreach ($data as $row) {
                // @phpstan-ignore method.notFound
                $this->assertDatabaseHas('users', [
                    'email' => $row[0],
                    'name' => $row[1],
                    'password' => $row[2],
                ]);
            }
        });
    });
    describe('Response', function () {
        it('Returns success response', function () {
            // @phpstan-ignore method.notFound
            $this->postJson(route('store'), [
                'model' => 'users',
                'file' => new UploadedFile(
                    __DIR__.'/../../assets/test.csv',
                    'test.csv',
                    'text/csv',
                    null,
                    true
                ),
                'fields' => [
                    [
                        'order' => 0,
                        'value' => 'email',
                    ],
                    [
                        'order' => 1,
                        'value' => 'name',
                    ],
                    [
                        'order' => 2,
                        'value' => 'password',
                    ],
                ],
            ])->assertOk()
                ->assertJson([
                    'message' => __('import::messages.success'),
                ]);
        });
    });
});
