<?php

namespace Meema\MeemaClient;

use Dotenv\Dotenv;
use GuzzleHttp\Client as GuzzleClient;
use Meema\MeemaClient\Functions\Image;
use Meema\MeemaClient\Functions\Video;
use Meema\MeemaClient\Models\Favorite;
use Meema\MeemaClient\Models\Folder;
use Meema\MeemaClient\Models\Media;
use Meema\MeemaClient\Models\Storage;
use Meema\MeemaClient\Models\Tag;

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
     * @var array
     */
    protected $config;

    /**
     * Construct Meema client.
     *
     * @param  string  $accessKey
     */
    public function __construct($accessKey, $config = [])
    {
        $this->initializeEnv();

        $this->accessKey = $accessKey;

        $this->config = $config;

        $url = $config['base_url'] ?? env('BASE_URL');

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
     * @param  string  $method
     * @param  string  $path
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

        if ($body && array_key_exists('data', $body)) {
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
     * @return Meema\MeemaClient\Models\Folder
     */
    public function folders(): Folder
    {
        return new Folder($this);
    }

    /**
     * Initialize the media model.
     *
     * @return Meema\MeemaClient\Models\Media
     */
    public function media(): Media
    {
        return new Media($this);
    }

    /**
     * Initialize the storage model.
     *
     * @return Meema\MeemaClient\Models\Storage
     */
    public function storage(): Storage
    {
        return new Storage($this);
    }

    /**
     * Initialize the media model.
     *
     * @return Meema\MeemaClient\Models\Tag
     */
    public function tags(): Tag
    {
        return new Tag($this);
    }

    /**
     * Initialize the favorite model.
     *
     * @return Meema\MeemaClient\Models\Favorite
     */
    public function favorites(): Favorite
    {
        return new Favorite($this);
    }

    /**
     * Initialize the on-the-fly image edit operations.
     *
     * @return Meema\MeemaClient\Functions\Image
     */
    public function image(): Image
    {
        return new Image($this);
    }

    /**
     * Initialize the on-the-fly image video operations.
     *
     * @return Meema\MeemaClient\Functions\Video
     */
    public function video(): Video
    {
        return new Video($this);
    }

    /**
     * Get the client config.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
}
