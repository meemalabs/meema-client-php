<?php

use Meema\MeemaClient\Tests\ClientTest;

uses(ClientTest::class);

beforeEach(function () {
    $this->initializeDotEnv();
    $this->initializeClient();
});

it('can fetch all tags', function () {
    $tags = $this->client->tags()->get();

    $this->assertTrue(is_array($tags));
    $this->assertTrue(count($tags) > 0);
});

it('can fetch specific group of tags', function () {
    $ids = [7, 8, 9];

    $tags = $this->client->tags()->get($ids);

    $this->assertTrue(is_array($tags));
    $this->assertTrue(count($tags) === count($ids));
});

it('can find a single tag', function () {
    $id = 7;

    $tags = $this->client->tags()->find($id)->toArray();

    $this->assertTrue(is_array($tags));
    $this->assertTrue(array_key_exists('id', $tags));
});

it('can update a tag', function () {
    $color = 'purple-600';

    $tags = $this->client->tags()->update(7, $color);

    $this->assertTrue(is_array($tags));
    $this->assertTrue($tags['color'] === $color);
});

it('can delete a tag', function () {
    $tags = $this->client->tags()->get();

    $tags = array_reverse($tags);
    $response = $this->client->tags()->delete($tags[0]['id']);

    $this->assertTrue(is_null($response));
});

it('can fetch all media tags', function () {
    $allMedia = $this->client->media()->get();

    $media = $this->client->media()->find($allMedia[0]['id']);

    $tags = $media->tags()->get();

    $this->assertTrue(is_array($tags));
    $this->assertTrue(count($tags[0]) > 0);
});

it('can fetch all folder tags', function () {
    $folders = $this->client->folders()->get();

    $folder = $this->client->folders()->find($folders[0]['id']);
    $tags = $folder->tags()->get();

    $this->assertTrue(is_array($tags));
    $this->assertTrue(count($tags[0]) > 0);
});
