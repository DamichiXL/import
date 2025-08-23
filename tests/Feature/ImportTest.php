<?php

use DamichiXL\Import\DTOs\ImportFieldDTO;
use DamichiXL\Import\DTOs\ImportModelDTO;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    Storage::fake('local');

    config()->set('import.models', [
        'users' => ImportModelDTO::make(
            name: 'Users',
            model: User::class,
            key: 'id',
            fields: [
                ImportFieldDTO::make(name: 'id', label: 'ID'),
                ImportFieldDTO::make(name: 'name', label: 'Name'),
                ImportFieldDTO::make(name: 'email', label: 'Email'),
            ]
        ),
    ]);
});

describe('Import', function () {
    it('Successfully stores imported data', function () {
        $this->postJson(route('store'), [
            'model' => 'users',
            'file' => UploadedFile::fake()->create(
                'users.xlsx',
                1000,
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ),
            'fields' => [
                [
                    'order' => 0,
                    'value' => 'name',
                ],
            ],
        ])->assertOk();
    });

    describe('Validation', function () {
        describe('Model', function () {
            it('Model not found', function () {
                $this->postJson(route('store'), [
                    'model' => 'NonExistentModel',
                ])->assertStatus(422)
                    ->assertJsonValidationErrors('model');
            });
        });

        describe('File', function () {
            it('File is required', function () {
                $this->postJson(route('store'))
                    ->assertStatus(422)
                    ->assertJsonValidationErrors('file');
            });

            it('File must be a file', function () {
                $this->postJson(route('store'), [
                    'file' => 'not-a-file',
                ])->assertStatus(422)
                    ->assertJsonValidationErrors('file');
            });

            it('File must be a xlsx', function () {
                $this->postJson(route('store'), [
                    'file' => UploadedFile::fake()->create(
                        'users.txt',
                        1000,
                        'text/plain',
                    ),
                ])->assertStatus(422)
                    ->assertJsonValidationErrors('file');
            });
        });

        describe('Fields', function () {
            it('Fields are required', function () {
                $this->postJson(route('store'), [
                    'fields' => [],
                ])->assertStatus(422)
                    ->assertJsonValidationErrors('fields');
            });

            it('Model not found', function () {
                $this->postJson(route('store'), [
                    'model' => 'users',
                    'file' => UploadedFile::fake()->create(
                        'users.xlsx',
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
});
