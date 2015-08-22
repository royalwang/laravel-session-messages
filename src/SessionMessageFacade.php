<?php
namespace Tarach\LSM;

use Illuminate\Support\Facades\Facade;

class SessionMessageFacade extends Facade
{
    /**
     * @inheritdoc
     */
    protected static function getFacadeAccessor()
    {
        return \Tarach\LSM\Message\Collection::IOC_ID;
    }
} 