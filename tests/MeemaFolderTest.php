<?php

use Tests\ClientTest;

uses(ClientTest::class);

beforeEach(function () {
    $this->initializeDotEnv();
    $this->initializeClient();
});

it('can fetch all folders', function () {
    $folders = $this->client->folders()->get();

    $this->assertTrue(is_array($folders));
    $this->assertTrue(count($folders) > 0);
});

it('can search a folder', function () {
    $folder = $this->client->folders()->find(1)->toArray();

    $query = $folder['name'];

    $folders = $this->client->folders()->search($query);

    $this->assertTrue(is_array($folders));
    $this->assertTrue(str_contains($folders[0]['name'], $query));
});

it('can fetch specific group of folders', function () {
    $ids = [1, 2, 3];

    $folders = $this->client->folders()->get($ids);

    $this->assertTrue(is_array($folders));
    $this->assertTrue(count($folders) === count($ids));
});

it('can find a single folder', function () {
    $id = 1;

    $folders = $this->client->folders()->find($id)->toArray();

    $this->assertTrue(is_array($folders));
    $this->assertTrue(array_key_exists('id', $folders));
});

it('can create a folder', function () {
    $name = 'test folder';

    $media = $this->client->folders()->create($name);

    $this->assertTrue(is_array($media));
    $this->assertTrue($media['name'] === $name);
});

it('can update a folder', function () {
    $name = 'test folder';

    $folders = $this->client->folders()->update(1, $name);

    $this->assertTrue(is_array($folders));
    $this->assertTrue($folders['name'] === $name);
});

it('can archive a folder', function () {
    $folders = $this->client->folders()->archive(1);

    $this->assertTrue(is_array($folders));
    $this->assertTrue((bool) $folders['is_archived']);
});

it('can unarchive a folder', function () {
    $folders = $this->client->folders()->unarchive(1);

    $this->assertTrue(is_array($folders));
    $this->assertFalse((bool) $folders['is_archived']);
});

it('can duplicate a folder', function () {
    $folders = $this->client->folders()->find(1);

    $duplicated = $folders->duplicate();

    $this->assertTrue(is_array($duplicated));
    $this->assertTrue($duplicated['name'] === $folders->toArray()['name']);
});

it('can delete a folder', function () {
    $folders = $this->client->folders()->get();

    $folders = array_reverse($folders);
    $response = $this->client->folders()->delete($folders[0]['id']);

    $this->assertTrue(is_null($response));
});
