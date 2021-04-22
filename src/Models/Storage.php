<?php

namespace Meema\MeemaClient\Models;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;
use Meema\MeemaClient\Client;

class Storage
{
    /**
     * @var \Meema\MeemaApi\Client
     */
    protected $client;

    /**
     * Construct storage model.
     *
     * @param Meema\MeemaApi\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Upload a media file.
     *
     * @param string $path
     *
     * @return array
     */
    public function upload($path)
    {
        try {
            $file = fopen($path, 'r');
            $fileName = basename($path);

            $stream = Utils::streamFor($file);
            $mimeType = mime_content_type($file);

            $signedUrl = $this->client->request('POST', 'storage/signed-url', ['content_type' => $mimeType]);

            if (is_array($signedUrl) && $signedUrl['url']) {
                $headers = $signedUrl['headers'];
                unset($headers['Host']);

                $this->uploadFile($signedUrl['url'], $headers, $fileName, $stream);

                $uploadData = ['key' => $signedUrl['key'], 'file_name' => $fileName];

                $response = $this->client->request('POST', 'upload', $uploadData);

                return $response;
            }
        } catch (Exception $e) {
            throw $e;
        }

        return ['message' => 'File did not successfully upload.'];
    }

    /**
     * Upload the file stream to s3.
     *
     * @param string $signedUrl
     * @param array $headers
     * @param string $fileName
     * @param GuzzleHttp\Psr7 $stream
     *
     * @return void
     */
    protected function uploadFile($signedUrl, $headers, $fileName, $stream)
    {
        $client = new GuzzleClient();
        $request = new Request(
            'PUT',
            $signedUrl,
            ['headers' => json_encode($headers)],
            new Psr7\MultipartStream(
                [
                    [
                        'name' => $fileName,
                        'contents' => $stream,
                    ],
                ]
            )
        );

        $client->send($request);
    }

    /**
     * Set the visibility for a file.
     *
     * @param string $path
     * @param string $visibility
     *
     * @return array|false file meta data
     */
    public function setVisibility($path, $visibility)
    {
        return $this->client->request('POST', 'storage/set-visibility', compact('path', 'visibility'));
    }

    /**
     * Check whether a file exists.
     *
     * @param string $path
     *
     * @return bool
     */
    public function has($path)
    {
        $data = $this->client->request('POST', 'storage/has', compact('path'));

        return $data['status'] ?? false;
    }

    /**
     * Get all the meta data of a file or directory.
     *
     * @param string $path
     *
     * @return false|array
     */
    public function getMetadata($path)
    {
        return $this->client->request('POST', 'storage/metadata', compact('path'));
    }

    /**
     * Destroy the file in storage.
     *
     * @param string $path
     *
     * @return array
     */
    public function delete($path)
    {
        return $this->client->request('POST', 'storage/destroy', compact('path'));
    }

    /**
     * Copy the file in storage.
     *
     * @param string $path
     *
     * @return array
     */
    public function copy($path, $newpath)
    {
        return $this->client->request('POST', 'storage/copy', compact('path', 'newpath'));
    }

    /**
     * Read a file in storage.
     *
     * @param string $path
     *
     * @return array
     */
    public function read($path)
    {
        return $this->client->request('POST', 'storage/read', compact('path'));
    }

    /**
     * Read the stream of a file in storage.
     *
     * @param string $path
     *
     * @return array
     */
    public function readStream($path)
    {
        return $this->client->request('POST', 'storage/read-stream', compact('path'));
    }

    /**
     * List contents of directory.
     *
     * @param string $path
     *
     * @return array
     */
    public function listContents($directory, $recursive = false)
    {
        return $this->client->request('POST', 'storage/list-contents', compact('directory', 'recursive'));
    }

    /**
     * Rename the file in storage.
     *
     * @param string $path
     *
     * @return array
     */
    public function rename($path, $newpath)
    {
        return $this->client->request('POST', 'storage/rename', compact('path', 'newpath'));
    }

    /**
     * Destroy the directory in storage.
     *
     * @param string $directory
     *
     * @return array
     */
    public function deleteDirectory($directory)
    {
        return $this->client->request('POST', 'storage/destroy-directory', compact('directory'));
    }

    /**
     * Create a directory in storage.
     *
     * @param string $directory
     *
     * @return array
     */
    public function makeDirectory($directory)
    {
        return $this->client->request('POST', 'storage/create-directory', compact('directory'));
    }
}
