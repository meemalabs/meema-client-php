<?php

namespace Meema\MeemaApi;

use GuzzleHttp\Client as GuzzleClient;

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
    public function __construct($accessKey)
    {
        $this->accessKey = $accessKey;
        $this->client = new GuzzleClient([
            'base_uri' => 'http://127.0.0.1:8000/api/',
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
        ])->getBody()->getContents();

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
     * List folders.
     *
     * @return array
     */
    public function listFolders()
    {
        return $this->request('GET', 'folders');
    }

    /**
     * Create folder.
     *
     * @param string $name
     *
     * @return array
     */
    public function createFolder($name)
    {
        return $this->request('POST', 'folders', compact('name'));
    }
}
