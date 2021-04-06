<?php

namespace Meema\MeemaApi\Models;

use Meema\MeemaApi\Client;
use Meema\MeemaApi\Response\Response;

class Media
{
    /**
     * @var \Meema\MeemaApi\Client
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
    public function update($id, $name): array
    {
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
        return $this->client->request('POST', "media/{$id}/archive");
    }

    /**
     * Unarchive a media.
     *
     * @param int $id
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
     * @param int $id
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
     * @param int $id
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
     * @param int $id
     *
     * @return array
     */
    public function duplicate($id): array
    {
        return $this->client->request('POST', "media/{$id}/duplicate");
    }

    /**
     * Initialize the folder model.
     *
     * @return Meema\MeemaApi\Models\Folder
     */
    public function folders($id = null)
    {
        $this->id = $id;

        return (new Folder($this->client))->setMedia($this);
    }

    /**
     * Initialize the tags model.
     *
     * @return Meema\MeemaApi\Models\Tag
     */
    public function tags($id = null): Tag
    {
        $this->id = $id;

        return (new Tag($this->client))->setMedia($this);
    }

    /**
     * Fetch the media for the folder.
     *
     * @param int $id
     *
     * @return self
     */
    public function setFolder($folder): self
    {
        $this->model = $folder;

        return $this;
    }

    /**
     * Initialize media model.
     *
     * @param Meema\MeemaApi\Models\Folder $folder
     *
     * @return self
     */
    public function setTag($tag): self
    {
        $this->model = $tag;

        return $this;
    }

    /**
     * Get the protected id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
        $data = [];

        switch (get_class($this->model)) {
            case Folder::class:
                $data = $this->fetchMediaForFolder($this->model->getId());
                break;
            case Tag::class:
                $data = $this->fetchMediaForTag($this->model->getId());
                break;
            default:
                $data = [];
                break;
        }

        return $data;
    }
}
