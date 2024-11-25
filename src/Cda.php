<?php

namespace Vinkas\Cda\Client;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
Use Illuminate\Support\Facades\Redirect;

class Cda
{
    protected $nonce;

    public function __construct(protected Application $app)
    {
        //
    }

    public function redirect($returnPath = '/'): RedirectResponse
    {
        $this->nonce = $this->generateNonce();
        Session::put($this->getNonceKey(), $returnPath);
        $payload = $this->getPayload();
        $signature = $this->getSignature($payload);
        $url = Config::get('cda.server_url').'/cda/'.Config::get('cda.client_id').'?payload='.$payload.'&signature='.$signature;
        return Redirect::to($url);
    }

    public function authenticate($request)
    {
        $payload = $request->input('payload');
        $signature = $request->input('signature');
        parse_str(base64_decode($payload), $payload);

        if ($signature != $this->getSignature($request->input('payload'))) {
            abort(403, 'Invalid request');
        }

        $nonceKey = $payload['nonce'];
        if (!Session::has($nonceKey)) {
            abort(403, 'Invalid request');
        }

        $userClass = Config::get('providers.users.model');
        $user = $userClass::where('id', $payload['id'])->first();
        if (!$user) {
            abort(403, 'Invalid request');
        }

        Auth::login($user, true);

        $returnPath = Session::pull($nonceKey);
        return Redirect::to($returnPath);
    }

    public function getPayload()
    {
        return base64_encode(http_build_query([
            'nonce' => $this->nonce,
        ]));
    }

    public function getSignature($payload)
    {
        return hash_hmac('sha256', $payload, Config::get('cda.client_secret'));
    }

    public function getNonceKey() {
        return 'CDA_NONCE_' . $this->nonce;
    }

    public function generateNonce()
    {
        return base64_encode(Encrypter::generateKey(Config::get('app.cipher')));
    }
}
