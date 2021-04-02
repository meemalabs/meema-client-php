<?php

namespace Meema\MeemaApi\Models;

use Meema\MeemaApi\Client;

class Media
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
     * Construct media model.
     *
     * @param Meema\MeemaApi\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all media.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->client->request('GET', 'media');
    }

    /**
     * Get specific media.
     *
     * @return array
     */
    public function get($id = null)
    {
        if (! $id) {
            return $this->all();
        }

        $ids = is_array($id) ? $id : func_get_args();

        return $this->client->request('GET', 'media/show', ['media_ids' => $ids]);
    }

    /**
     * Create media.
     *
     * @param  string $name
     *
     * @return array
     */
    public function create($name): array
    {
        $name = is_array($name) ? $name : compact('name');

        return $this->client->request('POST', "media/{$this->client->getAccessKey()}", $name);
    }

    /**
     * Update media.
     *
     * @param int $id
     * @param string $name
     *
     * @return array
     */
    public function update($id, $name): array
    {
        $name = is_array($name) ? $name : compact('name');

        return $this->client->request('PATCH', "media/{$id}/file-name", $name);
    }

    /**
     * Delete a media.
     *
     * @param int|array $id
     *
     * @return null
     */
    public function delete($id)
    {
        return $this->client->request('DELETE', "media/{$id}", ['media_id' => $id]);
    }

    /**
     * Archive a media.
     *
     * @return array
     */
    public function archive($id): array
    {
        return $this->client->request('POST', "media/{$id}/archive");
    }

    /**
     * Unarchive a media.
     *
     * @return array
     */
    public function unarchive($id): array
    {
        return $this->client->request('POST', "media/{$id}/unarchive");
    }

    /**
     * Make a media private.
     *
     * @return array
     */
    public function makePrivate($id): array
    {
        return $this->client->request('PATCH', "media/{$id}/make-private");
    }

    /**
     * Make a media public.
     *
     * @return array
     */
    public function makePublic($id): array
    {
        return $this->client->request('PATCH', "media/{$id}/make-public");
    }

    /**
     * Duplicate a media.
     *
     * @return array
     */
    public function duplicate($id): array
    {
        return $this->client->request('POST', "media/{$id}/duplicate");
    }
}
