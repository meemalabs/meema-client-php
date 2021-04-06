<?php

namespace Meema\MeemaApi\Models;

use Meema\MeemaApi\Client;
use Meema\MeemaApi\Response\Response;

class Team
{
    /**
     * @var Meema\MeemaApi\Client
     */
    protected $client;

    /**
     * Construct Folder model.
     *
     * @param Meema\MeemaApi\Client $client
     * @param int $teamId
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all teams.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->client->request('GET', 'teams');
    }

    /**
     * Get specific teams.
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

        return $this->client->request('GET', 'teams', ['team_ids' => $ids]);
    }

    /**
     * Get specific teams.
     *
     * @param int $id
     *
     * @return array
     */
    public function find($id)
    {
        $response = $this->client->request('GET', "teams/${id}");

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
        return $this->client->request('POST', 'teams', $data);
    }

    /**
     * Update folder.
     *
     * @param string $name
     * @param int $id
     *
     * @return array
     */
    public function update($id, $name): array
    {
        $name = is_array($name) ? $name : compact('name');

        return $this->client->request('PATCH', "teams/{$id}", $name);
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
        return $this->client->request('DELETE', "teams/{$id}");
    }

    /**
     * Delete a folder.
     *
     * @param int $id
     *
     * @return null
     */
    public function toggleMediaRecognition($id, $status)
    {
        return $this->client->request('POST', "teams/{$id}/toggle-media-recognition", compact('status'));
    }
}
