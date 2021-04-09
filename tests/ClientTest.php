<?php

namespace Tests;

use Meema\MeemaApi\Client;
use Orchestra\Testbench\TestCase;

class ClientTest extends TestCase
{
    public $client;

    public function initializeDotEnv(): void
    {
        if (! file_exists(dirname(__DIR__))) {
            return;
        }

        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(dirname(__DIR__)));
        $dotenv->load();
    }

    public function initializeClient()
    {
        $teamId = env('PUBLISHABLE_KEY');

        $client = new Client($teamId, env('BASE_URL_TEST'));

        $this->client = $client;

        return $this;
    }
}
