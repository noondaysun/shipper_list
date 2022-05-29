<?php

use App\Models\Contact;
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
    Contact::create([
        'shipper_id' => $shipper->id,
        'name' => 'John Doe',
        'contact_number' => '+1 (770) 854-3563',
        'contact_type' => 'primary',
    ]);
});

test('I can get a list of contacts', function () {
    $this->get('/api/v1/contacts')
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'contact_number',
                    'shipper_id',
                    'contact_type',
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

test('I can get a filtered list of contacts', function () {
    $this->get('/api/v1/contacts?name=John')
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'contact_number',
                    'shipper_id',
                    'contact_type',
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

test('I can get a single contact', function () {
    $this->get('/api/v1/contacts/'.Contact::first()->id)
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'contact_number',
                'shipper_id',
                'contact_type',
                'created_at',
                'updated_at',
            ],
            'links' => [
                'self',
            ],
        ]);
});

test('I can create a contact', function () {
    $user = User::inRandomOrder()->first();
    Sanctum::actingAs($user);

    $this->post('/api/v1/contacts', [
        'shipper_id' => Shipper::inRandomOrder()->first()->id,
        'name' => 'Maximillian Bills',
        'contact_number' => '+1 (770) 854-3563',
        'contact_type' => 'primary',
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

test('I can update a contact', function () {
    $user = User::inRandomOrder()->first();
    Sanctum::actingAs($user);

    $this->json('PUT', '/api/v1/contacts/'.Contact::first()->id, [
        'shipper_id' => Shipper::inRandomOrder()->first()->id,
        'name' => 'Maximillian Bills',
        'contact_type' => 'site',
        'contact_number' => '+1 (770) 854-3563',
    ])->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'contact_number',
                'shipper_id',
                'contact_type',
                'created_at',
                'updated_at',
            ],
            'links' => [
                'self',
            ],
        ])
        ->assertJsonFragment([
            'name' => 'Maximillian Bills',
            'contact_type' => 'site',
        ]);
});
