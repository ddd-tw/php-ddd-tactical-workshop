<?php

declare(strict_types=1);

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Mongo
 * @package App\Facades
 * @method static get(): MongoDB\Client\Client
 */
class Mongo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mongo';
    }
}