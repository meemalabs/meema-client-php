<?php

use Meema\MeemaClient\Tests\ClientTest;

uses(ClientTest::class);

beforeEach(function () {
    $this->initializeDotEnv();
    $this->initializeClient();
});

it('can be fetch all media', function () {
    $media = $this->client->media()->get();

    $this->assertTrue(is_array($media));
    $this->assertTrue(count($media) > 0);
});

it('can search a media', function () {
    $allMedia = $this->client->media()->get();

    $media = $this->client->media()->find($allMedia[0]['id'])->toArray();
    $query = $media['name'];

    $media = $this->client->media()->search($query);

    $this->assertTrue(is_array($media));
    $this->assertTrue(str_contains($media[0]['name'], $query));
});

it('can be fetch all media for a tag', function () {

    // 8 is the tag id for images
    $tag = $this->client->tags()->find(8);

    $media = $tag->media()->get();

    $this->assertTrue(is_array($media));
    $this->assertTrue(count($media) > 0);
});

it('can be fetch all media for a folder', function () {
    $allFolders = $this->client->folders()->get();

    // 8 is the tag id for images
    $folder = $this->client->folders()->find($allFolders[0]['id']);

    $media = $folder->media()->get();

    $this->assertTrue(is_array($media));
    $this->assertTrue(count($media) > 0);
});

it('can be fetch specific group of media', function () {
    $allMedia = $this->client->media()->get();

    $ids = [$allMedia[0]['id'], $allMedia[1]['id'], $allMedia[2]['id']];

    $media = $this->client->media()->get($ids);

    $this->assertTrue(is_array($media));
    $this->assertTrue(count($media) === count($ids));
});

it('can find a single media', function () {
    $allMedia = $this->client->media()->get();

    $id = $allMedia[0]['id'];

    $media = $this->client->media()->find($id)->toArray();

    $this->assertTrue(is_array($media));
    $this->assertTrue(array_key_exists('id', $media));
});

it('can update a media', function () {
    $allMedia = $this->client->media()->get();

    $name = 'test media';

    $media = $this->client->media()->update($allMedia[0]['id'], $name);

    $this->assertTrue(is_array($media));
    $this->assertTrue($media['name'] === $name);
});

it('can archive a media', function () {
    $allMedia = $this->client->media()->get();

    $media = $this->client->media()->archive($allMedia[0]['id']);

    $this->assertTrue(is_array($media));
    $this->assertTrue((bool) $media['is_archived']);
});

it('can unarchive a media', function () {
    $allMedia = $this->client->media()->get();

    $media = $this->client->media()->unarchive($allMedia[0]['id']);

    $this->assertTrue(is_array($media));
    $this->assertFalse((bool) $media['is_archived']);
});

it('can make a media private', function () {
    $allMedia = $this->client->media()->get();

    $media = $this->client->media()->makePrivate($allMedia[0]['id']);

    $this->assertTrue(is_array($media));
    $this->assertFalse((bool) $media['is_public']);
});

it('can make a media public', function () {
    $allMedia = $this->client->media()->get();

    $media = $this->client->media()->makePublic($allMedia[0]['id']);

    $this->assertTrue(is_array($media));
    $this->assertTrue((bool) $media['is_public']);
});

it('can duplicate a media', function () {
    $allMedia = $this->client->media()->get();

    $media = $this->client->media()->find($allMedia[0]['id']);

    $duplicated = $this->client->media()->duplicate($allMedia[0]['id']);

    $this->assertTrue(is_array($duplicated));
    $this->assertTrue($duplicated['name'] === $media->toArray()['name']);
});

it('can delete a media', function () {
    $media = $this->client->media()->get();

    $media = array_reverse($media);
    $response = $this->client->media()->delete($media[0]['id']);

    $this->assertTrue(is_null($response));
});
