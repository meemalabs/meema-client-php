<?php

namespace Meema\MeemaApi\Models;

use Meema\MeemaApi\Client;

class Folder
{   
    /**
     * @var Meema\MeemaApi\Client
     */
    public $client;

    /**
     * @var int $id
     */
    public $id;

    /**
     * Construct Folder model.
     *
     * @param Meema\MeemaApi\Client $client
     */
    public function __construct(Client $client, $id)
    {
        $this->client = $client;

        $this->id = $id;
    }

    /**
     * List all folders.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->client->request('GET', 'folders');
    }

    /**
     * Create folder.
     *
     * @param  string $name
     * 
     * @return array
     */
    public function create($name): array
    {
        return $this->client->request('POST', "folders/{$this->client->getAccessKey()}", compact('name'));
    }

    /**
     * Update folder.
     *
     * @param int $id
     * @param string $name
     * 
     * @return array
     */
    public function update($name): array
    {
        return $this->client->request('PATCH', "folders/{$this->id}", compact('name'));
    }

    /**
     * Delete a folder.
     *
     * @param int|array $id
     * 
     * @return array
     */
    public function delete(): array
    {
        return $this->client->request('DELETE', "folders/{$this->id}");
    }

    /**
     * Archive a folder.
     *
     * @return array
     */
    public function archive(): array
    {
        return $this->client->request('POST', "folders/{$this->id}/archive");
    }

    /**
     * Unarchive a folder.
     *
     * @return array
     */
    public function unarchive(): array
    {
        return $this->client->request('POST', "folders/{$this->id}/unarchive");
    }

    /**
     * Duplicate a folder.
     *
     * @return array
     */
    public function duplicate(): array
    {
        return $this->client->request('POST', "folders/{$this->id}/duplicate");
    }
}