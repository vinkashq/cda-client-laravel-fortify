<?php

namespace Vinkas\Cda\Client\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Vinkas\Cda\Client\Cda;

class CdaController extends Controller
{
    public function auth(Request $request)
    {
        $cda = new Cda(app());
        return $cda->redirect();
    }

    public function callback(Request $request)
    {
        $cda = new Cda(app());
        return $cda->authenticate($request);
    }
}
