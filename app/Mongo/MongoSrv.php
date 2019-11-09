<?php

declare(strict_types=1);

namespace App\Mongo;

use MongoDB\Client;

class MongoSrv
{
    private $mongo;

    public function __construct($uri = null, $uriOptions = [], $driverOptions = [])
    {
        $this->mongo = new Client($uri, $uriOptions, $driverOptions);
    }

    public function get(): Client
    {
        return $this->mongo;
    }
}