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
     * @var int
     */
    public $id;

    /**
     * Construct Folder model.
     *
     * @param Meema\MeemaApi\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
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
     * Get specific folders.
     *
     * @return array
     */
    public function get($id = null)
    {
        if (! $id) {
            return $this->all();
        }

        $ids = is_array($id) ? $id : func_get_args();

        return $this->client->request('GET', 'folders/show', ['folder_ids' => $ids]);
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
        $name = is_array($name) ? $name : compact('name');

        return $this->client->request('POST', "folders/{$this->client->getAccessKey()}", $name);
    }

    /**
     * Update folder.
     *
     * @param int $id
     * @param string $name
     *
     * @return array
     */
    public function update($id, $name): array
    {
        $name = is_array($name) ? $name : compact('name');

        return $this->client->request('PATCH', "folders/{$id}", $name);
    }

    /**
     * Delete a folder.
     *
     * @param int|array $id
     *
     * @return null
     */
    public function delete($id)
    {
        return $this->client->request('DELETE', "folders/{$id}");
    }

    /**
     * Archive a folder.
     *
     * @return array
     */
    public function archive($id): array
    {
        return $this->client->request('POST', "folders/{$id}/archive");
    }

    /**
     * Unarchive a folder.
     *
     * @return array
     */
    public function unarchive($id): array
    {
        return $this->client->request('POST', "folders/{$id}/unarchive");
    }

    /**
     * Duplicate a folder.
     *
     * @return array
     */
    public function duplicate($id): array
    {
        return $this->client->request('POST', "folders/{$id}/duplicate");
    }
}
