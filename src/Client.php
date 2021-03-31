<?php

namespace Meema\MeemaApi;

use GuzzleHttp\Client as GuzzleClient;
use Meema\MeemaApi\Models\Folder;

class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var Meema\MeemaApi\Models\Folder
     */
    public $folders;


    /**
     * @var string
     */
    protected $accessKey;

    /**
     * Construct Meema client.
     *
     * @param string $accessKey
     */
    public function __construct($accessKey)
    {
        $this->accessKey = $accessKey;
        $this->client = new GuzzleClient([
            'base_uri' => 'http://meema-api.test/api/',
        ]);
    }

    /**
     * Handle the API request.
     *
     * @param string $method
     * @param string $path
     *
     * @return array
     */
    public function request($method, $path, $data = null)
    {
        $content = $this->client->request($method, $path, [
            'json'    => $data,
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => "Bearer {$this->accessKey}",
            ],
        ])
        ->getBody()
        ->getContents();

        return json_decode($content, true);
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
     * Get the access key
     *
     * @return string
     */
    public function getAccessKey(): string
    {
        return $this->accessKey;
    }

    /**
     * Initialize the folder model
     *
     * @return Meema\MeemaApi\Models\Folder
     */
    public function folders($id = null): Folder
    {
        return new Folder($this, $id);
    }
}
