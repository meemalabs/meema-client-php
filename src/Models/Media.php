<?php

namespace Meema\MeemaApi\Models;

use Meema\MeemaApi\Client;
use Meema\MeemaApi\Response\Response;
use Meema\MeemaApi\Traits\SerializesResponse;

class Media
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
     * @var object
     */
    protected $model;

    /**
     * @var array
     */
    protected $content;

    /**
     * Construct media model.
     *
     * @param Meema\MeemaApi\Client $client
     */
    public function __construct(Client $client, $model = null)
    {
        $this->client = $client;

        $this->model = $model;
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
        if ($this->model) {
            return $this->fetchForModel();
        }

        if (! $id) {
            return $this->all();
        }

        $ids = is_array($id) ? $id : func_get_args();

        return $this->client->request('GET', 'media/show', ['media_ids' => $ids]);
    }

    /**
     * Get specific folders.
     *
     * @param int $id
     *
     * @return array
     */
    public function find($id)
    {
        $response = $this->client->request('GET', "folders/${id}");

        $this->content = $response;
        $this->id = $response['data']['id'];

        return new Response($this, $response);
    }

    /**
     * Create media.
     *
     * @param string $name
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
    public function update($name, $id = null): array
    {
        $id = $this->id ?? $id;

        $name = is_array($name) ? $name : compact('name');

        return $this->client->request('PATCH', "media/{$id}/file-name", $name);
    }

    /**
     * Delete a media.
     *
     * @param int $id
     *
     * @return null
     */
    public function delete($id = null)
    {
        $id = $this->id ?? $id;

        return $this->client->request('DELETE', "media/{$id}", ['media_id' => $id]);
    }

    /**
     * Archive a media.
     *
     * @param int $id
     *
     * @return array
     */
    public function archive($id = null): array
    {
        $id = $this->id ?? $id;

        return $this->client->request('POST', "media/{$id}/archive");
    }

    /**
     * Unarchive a media.
     *
     * @param int $id
     *
     * @return array
     */
    public function unarchive($id = null): array
    {
        $id = $this->id ?? $id;

        return $this->client->request('POST', "media/{$id}/unarchive");
    }

    /**
     * Make a media private.
     *
     * @param int $id
     *
     * @return array
     */
    public function makePrivate($id = null): array
    {
        $id = $this->id ?? $id;

        return $this->client->request('PATCH', "media/{$id}/make-private");
    }

    /**
     * Make a media public.
     *
     * @param int $id
     *
     * @return array
     */
    public function makePublic($id = null): array
    {
        $id = $this->id ?? $id;

        return $this->client->request('PATCH', "media/{$id}/make-public");
    }

    /**
     * Duplicate a media.
     *
     * @param int $id
     *
     * @return array
     */
    public function duplicate($id = null): array
    {
        $id = $this->id ?? $id;

        return $this->client->request('POST', "media/{$id}/duplicate");
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
     * Initialize the folder model.
     *
     * @return Meema\MeemaApi\Models\Tags
     */
    public function tags(): Tag
    {
        $client = new Client($this->client->getAccessKey());

        return new Tag($client, $this->id);
    }

    /**
     * Fetch the media for the folder.
     *
     * @param int $id
     *
     * @return array
     */
    public function fetchMediaForFolder($id): array
    {
        return $this->client->request('GET', "folders/{$id}/media");
    }

    /**
     * Fetch the media for tags.
     *
     * @param int $id
     *
     * @return array
     */
    public function fetchMediaForTag($id): array
    {
        return $this->client->request('GET', "tags/{$id}/media");
    }

    /**
     * Fetch child relations for this instance.
     *
     * @return array
     */
    public function fetchForModel()
    {
        switch (get_class($this->model)) {
            case Folder::class:
                return $this->fetchMediaForFolder($this->model->id);
            case Tag::class:
                return $this->fetchMediaForTag($this->model->id);
            default:
                break;
        }
    }
}
