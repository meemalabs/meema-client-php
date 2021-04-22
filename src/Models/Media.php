<?php

namespace Meema\MeemaClient\Models;

use Meema\MeemaClient\Client;
use Meema\MeemaClient\Exceptions\InvalidFormatException;
use Meema\MeemaClient\Response\Response;
use Meema\MeemaClient\Traits\CollectionsResponse;

class Media
{
    use CollectionsResponse;

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
     * @return \Illuminate\Support\Collection|array
     */
    public function all()
    {
        return $this->client->request('GET', 'media');
    }

    /**
     * Get specific media.
     *
     * @param array $ids
     *
     * @return \Illuminate\Support\Collection|array
     *
     * @throws InvalidFormatException
     */
    public function get($ids = null)
    {
        if ($this->model) {
            return $this->toCollection($this->fetchForModel());
        }

        if (! $ids) {
            return $this->toCollection($this->all());
        }

        $ids = is_array($ids) ? $ids : func_get_args();

        foreach ($ids as $id) {
            if (! is_int($id)) {
                throw new InvalidFormatException();
            }
        }

        $response = $this->client->request('GET', 'media', ['media_ids' => $ids]);

        return $this->toCollection($response);
    }

    /**
     * Search for specific media.
     *
     * @param string $query
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function search($query)
    {
        $response = $this->client->request('POST', 'media/search', compact('query'));

        return $this->toCollection($response);
    }

    /**
     * Get specific media.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function find($id)
    {
        if (! is_int($id)) {
            throw new InvalidFormatException();
        }

        $response = $this->client->request('GET', "media/${id}");

        return new Response($this, $response);
    }

    /**
     * Create media.
     *
     * @param string $name
     *
     * @return array
     */
    public function create($name)
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
     *
     * @throws InvalidFormatException
     */
    public function update($id, $name)
    {
        if (! is_int($id)) {
            throw new InvalidFormatException();
        }

        $name = is_array($name) ? $name : compact('name');

        return $this->client->request('PATCH', "media/{$id}/file-name", $name);
    }

    /**
     * Delete a media.
     *
     * @param array $ids
     *
     * @return null
     *
     * @throws InvalidFormatException
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
            return $this->client->request('POST', 'bulk/media/delete', ['media_ids' => $ids]);
        }

        // If count is equal to 1 get the first element
        $id = $ids[0];

        return $this->client->request('DELETE', "media/{$id}", ['media_id' => $id]);
    }

    /**
     * Archive a media.
     *
     * @param array $ids
     *
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function archive($ids)
    {
        $ids = is_array($ids) ? $ids : func_get_args();

        foreach ($ids as $id) {
            if (! is_int($id)) {
                throw new InvalidFormatException();
            }
        }

        if (count($ids) > 1) {
            return $this->client->request('POST', 'bulk/media/archive', ['media_ids' => $ids]);
        }

        // If count is equal to 1 get the first element
        $id = $ids[0];

        return $this->client->request('POST', "media/{$id}/archive");
    }

    /**
     * Unarchive a media.
     *
     * @param array $ids
     *
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function unarchive($ids)
    {
        $ids = is_array($ids) ? $ids : func_get_args();

        foreach ($ids as $id) {
            if (! is_int($id)) {
                throw new InvalidFormatException();
            }
        }

        if (count($ids) > 1) {
            return $this->client->request('POST', 'bulk/media/unarchive', ['media_ids' => $ids]);
        }

        // If count is equal to 1 get the first element
        $id = $ids[0];

        return $this->client->request('POST', "media/{$id}/unarchive");
    }

    /**
     * Make a media private.
     *
     * @param array $ids
     *
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function makePrivate($ids)
    {
        $ids = is_array($ids) ? $ids : func_get_args();

        foreach ($ids as $id) {
            if (! is_int($id)) {
                throw new InvalidFormatException();
            }
        }

        if (count($ids) > 1) {
            return $this->client->request('POST', 'bulk/media/make-private', ['media_ids' => $ids]);
        }

        // If count is equal to 1 get the first element
        $id = $ids[0];

        return $this->client->request('PATCH', "media/{$id}/make-private");
    }

    /**
     * Make a media public.
     *
     * @param array $ids
     *
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function makePublic($ids)
    {
        $ids = is_array($ids) ? $ids : func_get_args();

        foreach ($ids as $id) {
            if (! is_int($id)) {
                throw new InvalidFormatException();
            }
        }

        if (count($ids) > 1) {
            return $this->client->request('POST', 'bulk/media/make-public', ['media_ids' => $ids]);
        }

        // If count is equal to 1 get the first element
        $id = $ids[0];

        return $this->client->request('PATCH', "media/{$id}/make-public");
    }

    /**
     * Duplicate a media.
     *
     * @param array $ids
     *
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function duplicate($ids)
    {
        $ids = is_array($ids) ? $ids : func_get_args();

        foreach ($ids as $id) {
            if (! is_int($id)) {
                throw new InvalidFormatException();
            }
        }

        if (count($ids) > 1) {
            return $this->client->request('POST', 'bulk/media/duplicate', ['media_ids' => $ids]);
        }

        // If count is equal to 1 get the first element
        $id = $ids[0];

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
     * @param Meema\MeemaApi\Models\Tag $tag
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
    protected function fetchMediaForFolder($id)
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
    protected function fetchMediaForTag($id)
    {
        return $this->client->request('GET', "tags/{$id}/media");
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

    /**
     * Associate tag to a media.
     *
     * @param int $id
     * @param array $tag
     *
     * @return array
     */
    public function associateTag($id, $tag)
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
    public function disassociateTag($id, $tag)
    {
        return $this->client->request('POST', "media/{$id}/tag/detach", $tag);
    }
}
