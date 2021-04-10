<?php

uses(Tests\ClientTest::class);

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
    $this->assertTrue(count($tags['data']) === count($ids));
});

it('can find a single tag', function () {
    $id = 7;

    $tags = $this->client->tags()->find($id)->toArray();

    $this->assertTrue(is_array($tags));
    $this->assertTrue(count($tags) === 1);
});

it('can update a tag', function () {
    $color = 'purple-600';

    $tags = $this->client->tags()->update(7, $color);

    $this->assertTrue(is_array($tags));
    $this->assertTrue($tags['data']['color'] === $color);
});

it('can delete a tag', function () {
    $tags = $this->client->tags()->get();

    $tags = array_reverse($tags['data']);
    $response = $this->client->folders()->delete($tags[0]['id']);

    $this->assertTrue(is_null($response));
});

it('can fetch all media tags', function () {
    $media = $this->client->media()->find(1);
    $tags = $media->tags()->get();

    $this->assertTrue(is_array($tags));
    $this->assertTrue(count($tags['data'][0]) > 0);
});

it('can fetch all folder tags', function () {
    $folder = $this->client->folders()->find(1);
    $tags = $folder->tags()->get();

    $this->assertTrue(is_array($tags));
    $this->assertTrue(count($tags['data'][0]) > 0);
});
