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
    public function all()
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
    public function get($ids = null)
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
    public function update($id, $color)
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
     * Associate tags to a model.
     *
     * @param array $tag
     *
     * @return array
     */
    public function associate($tag)
    {
        return $this->associateToModel($tag);
    }

     /**
     * Associate tags to media.
     *
     * @param array $tag
     *
     * @return array
     */
    public function disassociate($tag)
    {
        return $this->disassociateToModel($tag);
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
    protected function fetchTagsForMedia($id)
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
    protected function fetchTagsForFolder($id)
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
    protected function fetchForModel()
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

    /**
     * Associate tags to a folder or media.
     *
     * @param array $tag
     *
     * @return array
     */
    protected function associateToModel($tag)
    {
        $data = [];

        switch (get_class($this->model)) {
            case Folder::class:
                $data = $this->associateTagToFolder($this->model->getId(), $tag);
                break;
            case Media::class:
                $data = $this->associateTagToMedia($this->model->getId(), $tag);
                break;
            default:
               $data = [];
        }

        return $data;
    }

    /**
     * Associate tags to a folder or media.
     *
     * @param array $tag
     *
     * @return array
     */
    protected function disassociateToModel($tag)
    {
        $data = [];

        switch (get_class($this->model)) {
            case Folder::class:
                $data = $this->disassociateTagFromFolder($this->model->getId(), $tag);
                break;
            case Media::class:
                $data = $this->disassociateTagFromMedia($this->model->getId(), $tag);
                break;
            default:
               $data = [];
        }

        return $data;
    }

    /**
     * Associate tag to a folder.
     *
     * @param int $id
     * @param array $tag
     *
     * @return array
     */
    protected function associateTagToFolder($id, $tag)
    {
        return $this->client->request('POST', "folders/{$id}/tag/attach", $tag);
    }

    /**
     * Disassociate tag from a folder.
     *
     * @param int $id
     * @param array $tag
     *
     * @return array
     */
    protected function disassociateTagFromFolder($id, $tag)
    {
        return $this->client->request('POST', "folders/{$id}/tag/detach", $tag);
    }

    /**
     * Associate tag to a media.
     *
     * @param int $id
     * @param array $tag
     *
     * @return array
     */
    protected function associateTagToMedia($id, $tag)
    {
        return $this->client->request('POST', "media/{$id}/tag/attach", $tag);
    }

    /**
     * Disassociate tag from a media.
     *
     * @param int $id
     * @param array $tag
     *
     * @return array
     */
    protected function disassociateTagFromMedia($id, $tag)
    {
        return $this->client->request('POST', "media/{$id}/tag/detach", $tag);
    }
}
