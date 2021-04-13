<?php

namespace Meema\MeemaApi\Models;

use Meema\MeemaApi\Client;
use Meema\MeemaApi\Exceptions\InvalidFormatException;
use Meema\MeemaApi\Response\Response;

class Tag
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
     * Construct Folder model.
     *
     * @param Meema\MeemaApi\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
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
     * @param array $ids
     *
     * @return array
     */
    public function get($ids = null): array
    {
        if ($this->model) {
            return $this->fetchForModel();
        }

        if (! $ids) {
            return $this->all();
        }

        $ids = is_array($ids) ? $ids : func_get_args();

        foreach ($ids as $id) {
            if (! is_int($id)) {
                throw new InvalidFormatException();
            }
        }

        return $this->client->request('GET', 'tags', ['tag_ids' => $ids]);
    }

    /**
     * Get specific tags.
     *
     * @param int $id
     *
     * @return Response
     */
    public function find($id): Response
    {
        if (! is_int($id)) {
            throw new InvalidFormatException();
        }

        $response = $this->client->request('GET', "tags/${id}");

        return new Response($this, $response);
    }

    /**
     * Update a tag color.
     *
     * @param int $id
     * @param string $color
     *
     * @return array
     */
    public function update($id, $color): array
    {
        if (! is_int($id)) {
            throw new InvalidFormatException();
        }

        $data = [
            'color' => $color,
            'tag_id' => $id,
        ];

        return $this->client->request('PATCH', 'tags/color', $data);
    }

    /**
     * Delete tags.
     *
     * @param array $ids
     *
     * @return Response
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
            return $this->client->request('POST', 'bulk/tags/delete', ['tag_ids' => $ids]);
        }

        // If count is equal to 1 get the first element
        $id = $ids[0];

        return $this->client->request('DELETE', "tags/{$id}");
    }

    /**
     * Initialize the media model.
     *
     * @param int $id
     *
     * @return Meema\MeemaApi\Models\Media
     */
    public function media($id = null): Media
    {
        $this->id = $id;

        return (new Media($this->client))->setTag($this);
    }

    /**
     * Initialize the folder model.
     *
     * @param int $id
     *
     * @return Meema\MeemaApi\Models\Folder
     */
    public function folders($id = null): Folder
    {
        $this->id = $id;

        return (new Folder($this->client))->setTag($this);
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
     * Initialize media model.
     *
     * @param Meema\MeemaApi\Models\Folder $folder
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
     * @param Meema\MeemaApi\Models\Media $media
     *
     * @return self
     */
    public function setMedia($media): self
    {
        $this->model = $media;

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
     * Fetch child relations for this instance.
     *
     * @return array
     */
    public function fetchForModel(): array
    {
        $data = [];

        switch (get_class($this->model)) {
            case Folder::class:
                $data = $this->fetchTagsForFolder($this->model->getId());
                break;
            case Media::class:
                $data = $this->fetchTagsForMedia($this->model->getId());
                break;
            default:
               $data = [];
        }

        return $data;
    }
}
