<?php

namespace Meema\MeemaApi\Models;

use Meema\MeemaApi\Client;
use Meema\MeemaApi\Response\Response;

class Folder
{
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
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all folders.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->client->request('GET', 'folders');
    }

    /**
     * Get specific folders.
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

        return $this->client->request('GET', 'folders', ['folder_ids' => $ids]);
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
     * Create folder.
     *
     * @param  string $name
     *
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
     * @param string $name
     * @param int $id
     *
     * @return array
     */
    public function update($name, $id = null): array
    {
        $id = $this->id ?? $id;

        $name = is_array($name) ? $name : compact('name');

        return $this->client->request('PATCH', "folders/{$id}", $name);
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
        if ($this->model) {
            return $this->deleteFolderFromMedia($this->model->getId(), $id);
        }

        $id = $this->id ?? $id;

        return $this->client->request('DELETE', "folders/{$id}");
    }

    /**
     * Archive a folder.
     *
     * @param int $id
     *
     * @return array
     */
    public function archive($id = null): array
    {
        $id = $this->id ?? $id;

        return $this->client->request('POST', "folders/{$id}/archive");
    }

    /**
     * Unarchive a folder.
     *
     * @param int $id
     *
     * @return array
     */
    public function unarchive($id = null): array
    {
        $id = $this->id ?? $id;

        return $this->client->request('POST', "folders/{$id}/unarchive");
    }

    /**
     * Duplicate a folder.
     *
     * @param int $id
     *
     * @return array
     */
    public function duplicate($id = null): array
    {
        $id = $this->id ?? $id;

        return $this->client->request('POST', "folders/{$id}/duplicate");
    }

    /**
     * Add folder to media.
     *
     * @param int $id
     *
     * @return array
     */
    public function addFolderToMedia($id, $name)
    {
        return $this->client->request('POST', "media/{$id}/folders", $name);
    }

    /**
     * Delete folder from media.
     *
     * @param int $id
     * @param int $folderId
     *
     * @return array
     */
    public function deleteFolderFromMedia($id, $folderId)
    {
        return $this->client->request('DELETE', "media/{$id}/folders/{$folderId}");
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
     * Get the protected id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Initialize the media model.
     *
     * @return Meema\MeemaApi\Models\Media
     */
    public function media(): Media
    {
        $client = new Client($this->client->getAccessKey());

        return (new Media($client))->setFolder($this);
    }

    /**
     * Initialize the tags model.
     *
     * @return Meema\MeemaApi\Models\Tag
     */
    public function tags(): Tag
    {
        $client = new Client($this->client->getAccessKey());

        return (new Tag($client))->setFolder($this);
    }
}
