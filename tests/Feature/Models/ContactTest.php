<?php

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;

test('I can get a list of contacts', function () {
    $this->get('/api/v1/contacts')
        ->dump()
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'phone',
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
        ->dump()
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'phone',
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
    $contact = Contact::create([
        'shipper_id' => 1,
        'name' => 'John Doe',
        'contact_number' => '+1 (770) 854-3563',
        'contact_type' => 'primary',
    ]);
    dd($contact);
    $this->get('/api/v1/contacts/'.$contact->id)
        ->dump()
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'phone',
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
        'shipper_id' => 3,
        'name' => 'Maximillian Bills',
        'contact_number' => '+1 (770) 854-3563',
        'contact_type' => 'primary',
    ])->dump()
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'phone',
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
