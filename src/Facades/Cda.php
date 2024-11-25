<?php

namespace Vinkas\Cda\Client\Facades;

use Illuminate\Support\Facades\Facade;

class Cda extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Vinkas\Cda\Client\Facades\Cda::class;
    }
}
