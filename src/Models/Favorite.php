<?php

namespace Meema\MeemaApi\Models;

use Meema\MeemaApi\Client;
use Meema\MeemaApi\Response\Response;
use Meema\MeemaApi\Traits\SerializesResponse;

class Favorite
{
    use SerializesResponse;

    /**
     * @var Meema\MeemaApi\Client
     */
    protected $client;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $favoriteId;

    /**
     * @var array
     */
    protected $content;

    /**
     * Construct Favorite model.
     *
     * @param Meema\MeemaApi\Client $client
     */
    public function __construct(Client $client, $favoriteId = null)
    {
        $this->client = $client;

        $this->favoriteId = $favoriteId;
    }

    /**
     * List all favorites.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->client->request('GET', 'favorites');
    }

    /**
     * Get specific favorites.
     *
     * @param int $id
     *
     * @return array
     */
    public function get($id = null)
    {
        if (! $id) {
            return $this->all();
        }

        $ids = is_array($id) ? $id : func_get_args();

        return $this->client->request('GET', 'favorites', ['favorite_ids' => $ids]);
    }

    /**
     * Get specific favorites.
     *
     * @param int $id
     *
     * @return array
     */
    public function find($id)
    {
        $response = $this->client->request('GET', "favorites/${id}");

        $this->content = $response;
        $this->id = $response['data']['id'];

        return new Response($this, $response);
    }

    /**
     * Create folder.
     *
     * @param  string $name
     *
     * @return array
     */
    public function create($data)
    {
        return $this->client->request('POST', "favorites/{$this->client->getAccessKey()}", $data);
    }

    /**
     * Update folder.
     *
     * @param string $name
     * @param int $id
     *
     * @return array
     */
    public function update($data, $id = null): array
    {
        $id = $this->id ?? $id;

        return $this->client->request('PATCH', "favorites/{$id}", $data);
    }

    /**
     * Delete a folder.
     *
     * @param int $id
     *
     * @return null
     */
    public function delete($id = null)
    {
        $id = $this->id ?? $id;

        return $this->client->request('DELETE', "favorites/{$id}");
    }
}
