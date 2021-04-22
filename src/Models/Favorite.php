<?php

namespace Meema\MeemaClient\Models;

use Meema\MeemaClient\Client;
use Meema\MeemaClient\Exceptions\InvalidFormatException;
use Meema\MeemaClient\Response\Response;
use Meema\MeemaClient\Traits\CollectionsResponse;

class Favorite
{
    use CollectionsResponse;

    /**
     * @var Meema\MeemaApi\Client
     */
    protected $client;

    /**
     * @var int
     */
    protected $id;

    /**
     * Construct Favorite model.
     *
     * @param Meema\MeemaApi\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all favorites.
     *
     * @return array
     */
    public function all()
    {
        return $this->client->request('GET', 'favorites');
    }

    /**
     * Get specific favorites.
     *
     * @param array $ids
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function get($ids = null)
    {
        if (! $ids) {
            return $this->toCollection($this->all());
        }

        $ids = is_array($ids) ? $ids : func_get_args();

        foreach ($ids as $id) {
            if (! is_int($id)) {
                throw new InvalidFormatException();
            }
        }

        $response = $this->client->request('GET', 'favorites', ['favorite_ids' => $ids]);

        return $this->toCollection($response);
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
        if (! is_int($id)) {
            throw new InvalidFormatException();
        }

        $response = $this->client->request('GET', "favorites/${id}");

        return new Response($this, $response);
    }

    /**
     * Create favorite.
     *
     * @param array $data
     *
     * @return array
     */
    public function create($data)
    {
        return $this->client->request('POST', "favorites/{$this->client->getAccessKey()}", $data);
    }

    /**
     * Update favorite.
     *
     * @param int $id
     * @param string $data
     *
     * @return array
     */
    public function update($id, $data)
    {
        if (! is_int($id)) {
            throw new InvalidFormatException();
        }

        return $this->client->request('PATCH', "favorites/{$id}", $data);
    }

    /**
     * Delete a favorite.
     *
     * @param array $ids
     *
     * @return null
     */
    public function delete($ids)
    {
        $ids = is_array($ids) ? $ids : func_get_args();

        foreach ($ids as $id) {
            if (! is_int($id)) {
                throw new InvalidFormatException();
            }
        }

        if (count($ids) > 1) {
            return $this->client->request('POST', 'bulk/favorites/delete', ['favorite_ids' => $ids]);
        }

        // If count is equal to 1 get the first element
        $id = $ids[0];

        return $this->client->request('DELETE', "favorites/{$id}");
    }
}
