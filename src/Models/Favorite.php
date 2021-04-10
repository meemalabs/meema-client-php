<?php

namespace Meema\MeemaApi\Models;

use Meema\MeemaApi\Client;
use Meema\MeemaApi\Exceptions\InvalidFormatException;
use Meema\MeemaApi\Response\Response;

class Favorite
{
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

        foreach ($ids as $id) {
            if (! is_int($id)) {
                throw new InvalidFormatException();
            }
        }

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
        if (! is_int($id)) {
            throw new InvalidFormatException();
        }

        $response = $this->client->request('GET', "favorites/${id}");

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
    public function update($id, $data): array
    {
        if (! is_int($id)) {
            throw new InvalidFormatException();
        }

        return $this->client->request('PATCH', "favorites/{$id}", $data);
    }

    /**
     * Delete a folder.
     *
     * @param int $id
     *
     * @return null
     */
    public function delete($id)
    {
        if (! is_int($id)) {
            throw new InvalidFormatException();
        }

        return $this->client->request('DELETE', "favorites/{$id}");
    }
}
