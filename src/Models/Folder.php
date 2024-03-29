<?php

namespace Meema\MeemaClient\Models;

use Meema\MeemaClient\Client;
use Meema\MeemaClient\Exceptions\InvalidFormatException;
use Meema\MeemaClient\Response\Response;
use Meema\MeemaClient\Traits\CollectionsResponse;
use Meema\MeemaClient\Traits\ValidsUuid;

class Folder
{
    use CollectionsResponse, ValidsUuid;

    /**
     * @var \Meema\MeemaClient\Client
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
     * @param  Meema\MeemaClient\Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all folders.
     *
     * @return array
     */
    public function all()
    {
        return $this->client->request('GET', 'folders');
    }

    /**
     * Get specific folders.
     *
     * @param  int  $id
     * @return \Illuminate\Support\Collection|array
     *
     * @throws InvalidFormatException
     */
    public function get($id = null)
    {
        if (! $id) {
            return $this->toCollection($this->all());
        }

        $ids = is_array($id) ? $id : func_get_args();

        foreach ($ids as $id) {
            if (! $this->isValidUuid($id)) {
                throw new InvalidFormatException('ID is not a valid UUID');
            }
        }

        $response = $this->client->request('GET', 'folders', ['folder_ids' => $ids]);

        return $this->toCollection($response);
    }

    /**
     * Search for specific folders.
     *
     * @param  string  $query
     * @return array
     */
    public function search($query)
    {
        $response = $this->client->request('POST', 'folders/search', compact('query'));

        return $this->toCollection($response);
    }

    /**
     * Get specific folders.
     *
     * @param  int  $id
     * @return Response
     *
     * @throws InvalidFormatException
     */
    public function find($id)
    {
        if (! $this->isValidUuid($id)) {
            throw new InvalidFormatException('ID is not a valid UUID');
        }

        $response = $this->client->request('GET', "folders/${id}");

        return new Response($this, $response);
    }

    /**
     * Create folder.
     *
     * @param  string  $name
     * @return array
     */
    public function create($name)
    {
        $name = is_array($name) ? $name : compact('name');

        if ($this->model) {
            $folderName = ['folder_name' => $name['name']];

            return $this->addFolderToMedia($this->model->getId(), $folderName);
        }

        return $this->client->request('POST', "folders/{$this->client->getAccessKey()}", $name);
    }

    /**
     * Update folder.
     *
     * @param  int  $id
     * @param  string  $name
     * @return array
     */
    public function update($id, $name)
    {
        if (! $this->isValidUuid($id)) {
            throw new InvalidFormatException('ID is not a valid UUID');
        }

        $name = is_array($name) ? $name : compact('name');

        return $this->client->request('PATCH', "folders/{$id}", $name);
    }

    /**
     * Delete a folder.
     *
     * @param  array  $ids
     * @return null
     *
     * @throws InvalidFormatException
     */
    public function delete($ids)
    {
        $ids = is_array($ids) ? $ids : func_get_args();

        foreach ($ids as $id) {
            if (! $this->isValidUuid($id)) {
                throw new InvalidFormatException('ID is not a valid UUID');
            }

            if ($this->model) {
                return $this->deleteFolderFromMedia($this->model->getId(), $id);
            }
        }

        if (count($ids) > 1) {
            return $this->client->request('POST', 'bulk/folders/delete', ['folder_ids' => $ids]);
        }

        // If count is equal to 1 get the first element
        $id = $ids[0];

        return $this->client->request('DELETE', "folders/{$id}");
    }

    /**
     * Archive a folder.
     *
     * @param  array  $ids
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function archive($ids)
    {
        $ids = is_array($ids) ? $ids : func_get_args();

        foreach ($ids as $id) {
            if (! $this->isValidUuid($id)) {
                throw new InvalidFormatException('ID is not a valid UUID');
            }
        }

        if (count($ids) > 1) {
            return $this->client->request('POST', 'bulk/folders/archive', ['folder_ids' => $ids]);
        }

        // If count is equal to 1 get the first element
        $id = $ids[0];

        return $this->client->request('POST', "folders/{$id}/archive");
    }

    /**
     * Unarchive a folder.
     *
     * @param  array  $ids
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function unarchive($ids)
    {
        $ids = is_array($ids) ? $ids : func_get_args();

        foreach ($ids as $id) {
            if (! $this->isValidUuid($id)) {
                throw new InvalidFormatException('ID is not a valid UUID');
            }
        }

        if (count($ids) > 1) {
            return $this->client->request('POST', 'bulk/folders/unarchive', ['folder_ids' => $ids]);
        }

        // If count is equal to 1 get the first element
        $id = $ids[0];

        return $this->client->request('POST', "folders/{$id}/unarchive");
    }

    /**
     * Duplicate a folder.
     *
     * @param  array  $ids
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function duplicate($ids)
    {
        $ids = is_array($ids) ? $ids : func_get_args();

        foreach ($ids as $id) {
            if (! $this->isValidUuid($id)) {
                throw new InvalidFormatException('ID is not a valid UUID');
            }
        }

        if (count($ids) > 1) {
            return $this->client->request('POST', 'bulk/folders/duplicate', ['folder_ids' => $ids]);
        }

        // If count is equal to 1 get the first element
        $id = $ids[0];

        return $this->client->request('POST', "folders/{$id}/duplicate");
    }

    /**
     * Add folder to media.
     *
     * @param  int  $id
     * @param  string  $name
     * @return array
     *
     * @throws InvalidFormatException
     */
    protected function addFolderToMedia($id, $name)
    {
        if (! $this->isValidUuid($id)) {
            throw new InvalidFormatException('ID is not a valid UUID');
        }

        return $this->client->request('POST', "media/{$id}/folders", $name);
    }

    /**
     * Delete folder from media.
     *
     * @param  int  $id
     * @param  int  $folderId
     * @return null
     *
     * @throws InvalidFormatException
     */
    protected function deleteFolderFromMedia($id, $folderId)
    {
        if (! $this->isValidUuid($id) || ! $this->isValidUuid($folderId)) {
            throw new InvalidFormatException('ID is not a valid UUID');
        }

        return $this->client->request('DELETE', "media/{$id}/folders/{$folderId}");
    }

    /**
     * Associate tag to a folder.
     *
     * @param  int  $id
     * @param  array  $tag
     * @return array
     */
    public function associateTag($id, $tag)
    {
        return $this->client->request('POST', "folders/{$id}/tag/attach", $tag);
    }

    /**
     * Disassociate tag from a folder.
     *
     * @param  int  $id
     * @param  array  $tag
     * @return array
     */
    public function disassociateTag($id, $tag)
    {
        return $this->client->request('POST', "folders/{$id}/tag/detach", $tag);
    }

    /**
     * Initialize media model.
     *
     * @param  Meema\MeemaClient\Models\Media  $media
     * @return self
     */
    public function setMedia($media): self
    {
        $this->model = $media;

        return $this;
    }

    /**
     * Initialize media model.
     *
     * @param  Meema\MeemaClient\Models\Tag  $tag
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
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Initialize the media model.
     *
     * @param  int  $id
     * @return Meema\MeemaClient\Models\Media
     */
    public function media($id = null): Media
    {
        $this->id = $id;

        return (new Media($this->client))->setFolder($this);
    }

    /**
     * Initialize the tags model.
     *
     * @param  int  $id
     * @return Meema\MeemaClient\Models\Tag
     */
    public function tags($id = null): Tag
    {
        $this->id = $id;

        return (new Tag($this->client))->setFolder($this);
    }
}
