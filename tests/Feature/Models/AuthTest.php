<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Http\Response;

test('sign-in', function () {
    $user = User::factory(1)->create();
    $this->post('/api/v1/auth/signin', [
        'email' => $user[0]->email,
        'password' => 'Right#Password1!',
    ])->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'user_id',
            'access_token',
            'type',
            'expires_at',
        ]);
});

test('sign-in fails', function () {
    $this->post('/api/v1/auth/signin', [
        'email' => 'does-not-exist@example.org',
        'password' => 'password',
    ])->assertStatus(Response::HTTP_UNAUTHORIZED)
        ->assertJsonStructure([
            'errors' => [
                '*' => [
                    'status',
                    'detail',
                ],
            ],
        ]);
});
