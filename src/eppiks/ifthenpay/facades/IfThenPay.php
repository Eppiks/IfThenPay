<?php namespace Eppiks\IfThenPay\Facades;

use Illuminate\Support\Facades\Facade;

class IfThenPay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'IfThenPay';
    }
}