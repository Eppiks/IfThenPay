<?php namespace Eppiks\IfThenPay\Facades;

use Illuminate\Support\Facades\Facade;

class IfThenPay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ifthenpay';
    }
}