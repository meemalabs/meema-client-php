<?php

uses(Tests\ClientTest::class);

beforeEach(function () {
    $this->initializeDotEnv();
    $this->initializeClient();
});

it('can be fetch all media', function () {
    $media = $this->client->media()->get();

    $this->assertTrue(is_array($media));
    $this->assertTrue(count($media) > 0);
});

it('can be fetch all media for a tag', function () {
    // 8 is the tag id for images
    $tag = $this->client->tags()->find(8);

    $media = $tag->media()->get();

    $this->assertTrue(is_array($media));
    $this->assertTrue(count($media) > 0);
});

it('can be fetch all media for a folder', function () {
    // 8 is the tag id for images
    $folder = $this->client->folders()->find(1);

    $media = $folder->media()->get();

    $this->assertTrue(is_array($media));
    $this->assertTrue(count($media) > 0);
});


it('can be fetch specific group of media', function () {
    $ids = [1, 2, 3];

    $media = $this->client->media()->get($ids);

    $this->assertTrue(is_array($media));
    $this->assertTrue(count($media['data']) === count($ids));
});

it('can find a single media', function () {
    $id = 1;

    $media = $this->client->media()->find($id)->toArray();

    $this->assertTrue(is_array($media));
    $this->assertTrue(count($media) === 1);
});

it('can update a media', function () {
    $name = 'test media';

    $media = $this->client->media()->update(1, $name);

    $this->assertTrue(is_array($media));
    $this->assertTrue($media['data']['name'] === $name);
});

it('can search a media', function () {
    $query = 'butterfly';

    $media = $this->client->media()->search($query);

    $this->assertTrue(is_array($media));
    $this->assertTrue(str_contains($media['data'][0]['name'], $query));
});

it('can archive a media', function () {
    $media = $this->client->media()->archive(1);

    $this->assertTrue(is_array($media));
    $this->assertTrue((bool) $media['data']['is_archived']);
});

it('can unarchive a media', function () {
    $media = $this->client->media()->unarchive(1);

    $this->assertTrue(is_array($media));
    $this->assertFalse((bool) $media['data']['is_archived']);
});

it('can make a media private', function () {
    $media = $this->client->media()->makePrivate(1);

    $this->assertTrue(is_array($media));
    $this->assertFalse((bool) $media['data']['is_public']);
});

it('can make a media public', function () {
    $media = $this->client->media()->makePublic(1);

    $this->assertTrue(is_array($media));
    $this->assertTrue((bool) $media['data']['is_public']);
});

it('can duplicate a media', function () {
    $media = $this->client->media()->find(1);

    $duplicated = $this->client->media()->duplicate(1);

    $this->assertTrue(is_array($duplicated));
    $this->assertTrue($duplicated['data']['name'] === $media->toArray()['data']['name']);
});

it('can delete a media', function () {
    $media = $this->client->media()->get();

    $media = array_reverse($media['data']);
    $response = $this->client->media()->delete((int) $media[0]['media_id']);

    $this->assertTrue(is_null($response));
});
