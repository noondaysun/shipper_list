<?php

use App\Models\Shipper;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    User::factory(1)->create();
    $shipper = Shipper::create([
        'name' => 'Kris Inc',
        'address' => '123 Main St',
    ]);
});

test('I can get a list of shippers', function () {
    $this->get('/api/v1/shippers')
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'address',
                    'created_at',
                    'updated_at',
                ],
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links',
                'path',
                'per_page',
                'to',
                'total',
            ],
        ]);
});

test('I can get a filtered list of shippers', function () {
    $this->get('/api/v1/shippers?name=Kris')
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'address',
                    'created_at',
                    'updated_at',
                ],
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links',
                'path',
                'per_page',
                'to',
                'total',
            ],
        ]);
});

test('I can get a single shipper', function () {
    $this->get('/api/v1/shippers/'.Shipper::first()->id)
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'address',
                'created_at',
                'updated_at',
            ],
            'links' => [
                'self',
            ],
        ]);
});

test('I can create a shipper', function () {
    $user = User::inRandomOrder()->first();
    Sanctum::actingAs($user);

    $this->post('/api/v1/shippers', [
        'shipper_id' => Shipper::inRandomOrder()->first()->id,
        'name' => 'Maximillian Bills Inc.',
        'address' => '47 Upperthong Ln\\nHolmfirth\\nHD9 3UZ',
    ])->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure([
            'data' => [
                'id',
            ],
            'links' => [
                'self',
            ],
        ]);
});

test('I can update a shipper', function () {
    $user = User::inRandomOrder()->first();
    Sanctum::actingAs($user);

    $this->json('PUT', '/api/v1/shippers/'.Shipper::first()->id, [
        'shipper_id' => Shipper::inRandomOrder()->first()->id,
        'name' => 'Maximillian Bills Pty Ltd',
        'address' => '47 Upperthong Ln\\nHolmfirth\\nHD9 3UZ',
    ])->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'address',
                'created_at',
                'updated_at',
            ],
            'links' => [
                'self',
            ],
        ])
        ->assertJsonFragment([
            'name' => 'Maximillian Bills Pty Ltd',
            'address' => '47 Upperthong Ln\\nHolmfirth\\nHD9 3UZ',
        ]);
});
