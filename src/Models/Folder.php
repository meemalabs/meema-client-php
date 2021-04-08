<?php

namespace Meema\MeemaApi\Models;

use Meema\MeemaApi\Client;
use Meema\MeemaApi\Exceptions\InvalidFormatException;
use Meema\MeemaApi\Response\Response;

class Folder
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
     * @return mixed
     *
     * @throws InvalidFormatException
     */
    public function get($id = null)
    {
        if (! $id) {
            return $this->all();
        }

        try {
            if (! is_int($id)) {
                throw new InvalidFormatException();
            }

            $ids = is_array($id) ? $id : func_get_args();
        } catch (InvalidFormatException $e) {
            return $e->getMessage();
        }

        return $this->client->request('GET', 'folders', ['folder_ids' => $ids]);
    }

    /**
     * Get specific folders.
     *
     * @param int $id
     *
     * @return Response
     *
     * @throws InvalidFormatException
     */
    public function find($id)
    {
        try {
            if (! is_int($id)) {
                throw new InvalidFormatException();
            }

            $response = $this->client->request('GET', "folders/${id}");
        } catch (InvalidFormatException $e) {
            return $e->getMessage();
        }

        return new Response($this, $response);
    }

    /**
     * Create folder.
     *
     * @param  string $name
     *
     * @return array
     */
    public function create($name): array
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
     * @param int $id
     * @param string $name
     *
     * @return array
     */
    public function update($id, $name): array
    {
        try {
            if (! is_int($id)) {
                throw new InvalidFormatException();
            }

            $name = is_array($name) ? $name : compact('name');
        } catch (InvalidFormatException $e) {
            return $e->getMessage();
        }

        return $this->client->request('PATCH', "folders/{$id}", $name);
    }

    /**
     * Delete a folder.
     *
     * @param int $id
     *
     * @return null
     *
     * @throws InvalidFormatException
     */
    public function delete($id)
    {
        $ids = is_array($id) ? $id : func_get_args();

        try {
            foreach ($ids as $id) {
                if (! is_int($id)) {
                    throw new InvalidFormatException();
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
        } catch (InvalidFormatException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get specific folders.
     *
     * @param string $query
     *
     * @return array
     */
    public function search($query)
    {
        return $this->client->request('POST', 'folders/search', compact('query'));
    }

    /**
     * Archive a folder.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function archive($id)
    {
        $ids = is_array($id) ? $id : func_get_args();

        try {
            foreach ($ids as $id) {
                if (! is_int($id)) {
                    throw new InvalidFormatException();
                }
            }

            if (count($ids) > 1) {
                return $this->client->request('POST', 'bulk/folders/archive', ['folder_ids' => $ids]);
            }

            // If count is equal to 1 get the first element
            $id = $ids[0];

            return $this->client->request('POST', "folders/{$id}/archive");
        } catch (InvalidFormatException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Unarchive a folder.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function unarchive($id)
    {
        $ids = is_array($id) ? $id : func_get_args();

        try {
            foreach ($ids as $id) {
                if (! is_int($id)) {
                    throw new InvalidFormatException();
                }
            }

            if (count($ids) > 1) {
                return $this->client->request('POST', 'bulk/folders/unarchive', ['folder_ids' => $ids]);
            }

            // If count is equal to 1 get the first element
            $id = $ids[0];

            return $this->client->request('POST', "folders/{$id}/unarchive");
        } catch (InvalidFormatException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Duplicate a folder.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function duplicate($id): array
    {
        $ids = is_array($id) ? $id : func_get_args();

        try {
            foreach ($ids as $id) {
                if (! is_int($id)) {
                    throw new InvalidFormatException();
                }
            }

            if (count($ids) > 1) {
                return $this->client->request('POST', 'bulk/folders/duplicate', ['folder_ids' => $ids]);
            }

            // If count is equal to 1 get the first element
            $id = $ids[0];

            return $this->client->request('POST', "folders/{$id}/duplicate");
        } catch (InvalidFormatException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Add folder to media.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function addFolderToMedia($id, $name): array
    {
        try {
            if (! is_int($id)) {
                throw new InvalidFormatException();
            }

            return $this->client->request('POST', "media/{$id}/folders", $name);
        } catch (InvalidFormatException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Delete folder from media.
     *
     * @param int $id
     * @param int $folderId
     *
     * @return null
     *
     * @throws InvalidFormatException
     */
    public function deleteFolderFromMedia($id, $folderId)
    {
        try {
            if (! is_int($id) || ! is_int($folderId)) {
                throw new InvalidFormatException();
            }

            return $this->client->request('DELETE', "media/{$id}/folders/{$folderId}");
        } catch (InvalidFormatException $e) {
            return $e->getMessage();
        }
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
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Initialize the media model.
     *
     * @return Meema\MeemaApi\Models\Media
     */
    public function media($id = null): Media
    {
        $this->id = $id;

        return (new Media($this->client))->setFolder($this);
    }

    /**
     * Initialize the tags model.
     *
     * @return Meema\MeemaApi\Models\Tag
     */
    public function tags($id = null): Tag
    {
        $this->id = $id;

        return (new Tag($this->client))->setFolder($this);
    }
}
