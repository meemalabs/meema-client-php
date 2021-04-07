<?php

namespace Tests;

use Meema\MeemaApi\Client;
use Orchestra\Testbench\TestCase;

class ClientTest extends TestCase
{
    public $client;

    public function initializeDotEnv(): void
    {
        if (! file_exists(__DIR__.'/../.env')) {
            return;
        }

        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
    }

    public function initializeClient()
    {
        $teamId = 'pk_live|2|1|M3g6t5NxE5pdSWq833zG0BFf0LbBO2j9bX8FP4ft';

        $client = new Client($teamId);

        $this->client = $client;

        return $this;
    }
}
