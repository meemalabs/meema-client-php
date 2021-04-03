<?php

namespace Meema\MeemaApi\Models;

use Meema\MeemaApi\Client;
use Meema\MeemaApi\Response\Response;
use Meema\MeemaApi\Traits\SerializesResponse;

class Tag
{
    use SerializesResponse;

    /**
     * @var Meema\MeemaApi\Client
     */
    protected $client;

    /**
     * @var int
     */
    public $id;

    /**
     * @var object
     */
    protected $model;

    /**
     * @var array
     */
    protected $content;

    /**
     * Construct Folder model.
     *
     * @param Meema\MeemaApi\Client $client
     */
    public function __construct(Client $client, $model = null)
    {
        $this->client = $client;

        $this->model = $model;
    }

    /**
     * List all tags.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->client->request('GET', 'tags');
    }

    /**
     * Get specific tags.
     *
     * @param int $id
     *
     * @return array
     */
    public function get($id = null)
    {
        if ($this->model) {
            return $this->fetchForModel();
        }

        if (! $id) {
            return $this->all();
        }

        $ids = is_array($id) ? $id : func_get_args();

        return $this->client->request('GET', 'tags', ['tag_ids' => $ids]);
    }

    /**
     * Get specific tags.
     *
     * @param int $id
     *
     * @return array
     */
    public function find($id)
    {
        $response = $this->client->request('GET', "tags/${id}");

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
    public function create($name)
    {
        $name = is_array($name) ? $name : compact('name');

        return $this->client->request('POST', "tags/{$this->client->getAccessKey()}", $name);
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

        return $this->client->request('PATCH', 'tags/color', $data);
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

        return $this->client->request('DELETE', "tags/{$id}");
    }


    /**
     * Initialize the media model.
     *
     * @return Meema\MeemaApi\Models\Media
     */
    public function media(): Media
    {
        $client = new Client($this->client->getAccessKey());

        return new Media($client, $this);
    }

    /**
     * Initialize the folder model.
     *
     * @return Meema\MeemaApi\Models\Folder
     */
    public function folders(): Folder
    {
        $client = new Client($this->client->getAccessKey());

        return new Folder($client, $this);
    }

    /**
     * Fetch the tags for media.
     *
     * @param int $id
     *
     * @return array
     */
    public function fetchTagsForMedia($id): array
    {
        return $this->client->request('GET', "media/{$id}/tags");
    }

    /**
     * Fetch the tags for folders.
     *
     * @param int $id
     *
     * @return array
     */
    public function fetchTagsForFolder($id): array
    {
        return $this->client->request('GET', "folders/{$id}/tags");
    }

    /**
     * Fetch child relations for this instance.
     *
     * @return array
     */
    public function fetchForModel(): array
    {
        switch (get_class($this->model)) {
            case Folder::class:
                return $this->fetchTagsForFolder($this->model->id);
            case Media::class:
                return $this->fetchTagsForMedia($this->model->id);
            default:
               return [];
        }

        return [];
    }
}
