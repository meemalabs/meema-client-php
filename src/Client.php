<?php

namespace Meema\MeemaApi;

use Dotenv\Dotenv;
use GuzzleHttp\Client as GuzzleClient;
use Meema\MeemaApi\Models\Favorite;
use Meema\MeemaApi\Models\Folder;
use Meema\MeemaApi\Models\Media;
use Meema\MeemaApi\Models\Tag;

class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $accessKey;

    /**
     * Construct Meema client.
     *
     * @param string $accessKey
     */
    public function __construct($accessKey, $baseUrl = null)
    {
        $this->initializeEnv();

        $this->accessKey = $accessKey;

        $url = $baseUrl ?? env('BASE_URL');

        $this->client = new GuzzleClient([
            'base_uri' => $url ?? 'https://api.mee.ma',
        ]);
    }

    /**
     * Initialize env variables.
     *
     * @return void
     */
    public function initializeEnv()
    {
        if (! file_exists(__DIR__.'/../.env')) {
            return;
        }

        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
    }

    /**
     * Handle the API request.
     *
     * @param string $method
     * @param string $path
     */
    public function request($method, $path, $data = null)
    {
        $content = $this->client->request($method, $path, [
            'query'   => $data,
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => "Bearer {$this->accessKey}",
            ],
        ])
        ->getBody()
        ->getContents();

        $body = json_decode($content, true);

        if ($body && $body['data']) {
            return $body['data'];
        }

        return $body;
    }

    /**
     * Generate Meema signed URL.
     *
     * @return array
     */
    public function signedUrl()
    {
        return $this->request('POST', 'vapor/signed-storage-url');
    }

    /**
     * Get the access key.
     *
     * @return string
     */
    public function getAccessKey(): string
    {
        return $this->accessKey;
    }

    /**
     * Initialize the folder model.
     *
     * @return Meema\MeemaApi\Models\Folder
     */
    public function folders(): Folder
    {
        return new Folder($this);
    }

    /**
     * Initialize the media model.
     *
     * @return Meema\MeemaApi\Models\Media
     */
    public function media(): Media
    {
        return new Media($this);
    }

    /**
     * Initialize the media model.
     *
     * @return Meema\MeemaApi\Models\Tag
     */
    public function tags(): Tag
    {
        return new Tag($this);
    }

    /**
     * Initialize the favorite model.
     *
     * @return Meema\MeemaApi\Models\Favorite
     */
    public function favorites(): Favorite
    {
        return new Favorite($this);
    }
}
