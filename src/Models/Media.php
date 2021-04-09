<?php

namespace Meema\MeemaApi\Models;

use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client as GuzzleClient;
use Meema\MeemaApi\Client;
use Meema\MeemaApi\Exceptions\InvalidFormatException;
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
     *
     * @throws InvalidFormatException
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

        foreach ($ids as $id) {
            if (! is_int($id)) {
                throw new InvalidFormatException();
            }
        }

        return $this->client->request('GET', 'media', ['media_ids' => $ids]);
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
     * @param int $id
     *
     * @return null
     *
     * @throws InvalidFormatException
     */
    public function delete($id)
    {
        $ids = is_array($id) ? $id : func_get_args();

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
     * Get specific folders.
     *
     * @param string $query
     *
     * @return array
     */
    public function search($query)
    {
        return $this->client->request('POST', 'media/search', compact('query'));
    }

    /**
     * Upload a media file.
     *
     * @param string $path
     *
     * @return array
     */
    public function upload($path)
    {
        $file = fopen($path, 'r');
        $stream = Psr7\stream_for($file);

        $fileName = basename($path);
        $mimeType = mime_content_type($file);

        $vaporParams = ['content_type' => $mimeType];

        $signedUrl = $this->client->request('POST', 'vapor/signed-storage-url', $vaporParams);

        if (is_array($signedUrl) && $signedUrl['url']) {
            $headers = $signedUrl['headers'];
            unset($headers['Host']);

            $this->uploadToS3($signedUrl, $headers, $fileName, $stream);

            $uploadData = ['key' => $signedUrl['key'], 'file_name' => $fileName];

            $response = $this->client->request('POST', 'upload', $uploadData);
        }

        return $response;
    }

    /**
     * Upload the file stream to s3.
     *
     * @param array $signedUrl
     * @param array $headers
     * @param string $fileName
     * @param GuzzleHttp\Psr7 $stream
     *
     * @return void
     */
    protected function uploadToS3($signedUrl, $headers, $fileName, $stream)
    {
        $client  = new GuzzleClient();
        $request = new Request(
            'PUT',
            $signedUrl['url'],
            ['headers' => json_encode($headers)],
            new Psr7\MultipartStream(
                [
                    [
                        'name' => $fileName,
                        'contents' => $stream,
                    ],
                ]
            )
        );

        $client->send($request);
    }

    /**
     * Archive a media.
     *
     * @param array $id
     *
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function archive($id)
    {
        $ids = is_array($id) ? $id : func_get_args();

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
     * @param array $id
     *
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function unarchive($id)
    {
        $ids = is_array($id) ? $id : func_get_args();

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
     * @param array $id
     *
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function makePrivate($id)
    {
        $ids = is_array($id) ? $id : func_get_args();

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
     * @param int $id
     *
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function makePublic($id)
    {
        $ids = is_array($id) ? $id : func_get_args();

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
     * @param int $id
     *
     * @return array
     *
     * @throws InvalidFormatException
     */
    public function duplicate($id)
    {
        $ids = is_array($id) ? $id : func_get_args();

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
