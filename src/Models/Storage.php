<?php

namespace Meema\MeemaClient\Models;

use Meema\MeemaClient\Client;

class Storage
{
    /**
     * @var \Meema\MeemaClient\Client
     */
    protected $client;

    /**
     * Construct storage model.
     *
     * @param  Meema\MeemaClient\Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Upload a media file.
     *
     * @param  string  $path
     * @return array
     */
    public function upload($path, $contents = null, $config = [])
    {
        return $this->client->request('POST', 'storage/upload', compact('path', 'contents', 'config'));
    }

    /**
     * Set the visibility for a file.
     *
     * @param  string  $path
     * @param  string  $visibility
     * @return array|false file meta data
     */
    public function setVisibility($path, $visibility)
    {
        return $this->client->request('POST', 'storage/set-visibility', compact('path', 'visibility'));
    }

    /**
     * Check whether a file exists.
     *
     * @param  string  $path
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
     * @param  string  $path
     * @return false|array
     */
    public function getMetadata($path)
    {
        return $this->client->request('POST', 'storage/metadata', compact('path'));
    }

    /**
     * Destroy the file in storage.
     *
     * @param  string  $path
     * @return array
     */
    public function delete($path)
    {
        return $this->client->request('POST', 'storage/destroy', compact('path'));
    }

    /**
     * Copy the file in storage.
     *
     * @param  string  $path
     * @return array
     */
    public function copy($path, $newpath)
    {
        return $this->client->request('POST', 'storage/copy', compact('path', 'newpath'));
    }

    /**
     * Read a file in storage.
     *
     * @param  string  $path
     * @return array
     */
    public function read($path)
    {
        return $this->client->request('POST', 'storage/read', compact('path'));
    }

    /**
     * Read the stream of a file in storage.
     *
     * @param  string  $path
     * @return array
     */
    public function readStream($path)
    {
        return $this->client->request('POST', 'storage/read-stream', compact('path'));
    }

    /**
     * List contents of directory.
     *
     * @param  string  $path
     * @return array
     */
    public function listContents($directory, $recursive = false)
    {
        return $this->client->request('POST', 'storage/list-contents', compact('directory', 'recursive'));
    }

    /**
     * Rename the file in storage.
     *
     * @param  string  $path
     * @return array
     */
    public function rename($path, $newpath)
    {
        return $this->client->request('POST', 'storage/rename', compact('path', 'newpath'));
    }

    /**
     * Destroy the directory in storage.
     *
     * @param  string  $directory
     * @return array
     */
    public function deleteDirectory($directory)
    {
        return $this->client->request('POST', 'storage/destroy-directory', compact('directory'));
    }

    /**
     * Create a directory in storage.
     *
     * @param  string  $directory
     * @return array
     */
    public function makeDirectory($directory)
    {
        return $this->client->request('POST', 'storage/create-directory', compact('directory'));
    }
}
