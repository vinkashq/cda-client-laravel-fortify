<?php

use Workbench\App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

test('authenticates user', function () {
    $user = User::factory()->create();
    $nonce = Str::random(40);
    Session::put('CDA_NONCE_'.$nonce, '/');

    $payload = base64_encode(http_build_query([
        'nonce' => $nonce,
        'id' => $user->id,
    ]));

    $signature = hash_hmac('sha256', $payload, config('cda.client_secret'));
    $response = $this->get('/cda/callback?payload='.$payload.'&signature='.$signature);

    $response->assertStatus(302);
    $response->assertRedirect('/');
    expect(Auth::user()->id)->toBe($user->id);
});
