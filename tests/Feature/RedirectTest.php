<?php

use Illuminate\Support\Facades\Session;

test('redirects to Laravel Fortify server URL', function () {
    $response = $this->get('/cda/auth');

    $response->assertStatus(302);
    $url = $response->headers->get('Location');
    expect($url)->toStartWith(config('cda.server_url'));

    $query = parse_url($url)['query'];
    parse_str($query, $query);
    $payload = $query['payload'];
    $signature = $query['signature'];

    expect($signature)->toBe(hash_hmac('sha256', $payload, config('cda.client_secret')));
    parse_str(base64_decode($payload), $payload);
    expect(Session::get('CDA_NONCE_'.$payload['nonce']))->toBe('/');
});
