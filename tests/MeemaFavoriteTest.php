<?php

uses(Tests\ClientTest::class);

beforeEach(function () {
    $this->initializeDotEnv();
    $this->initializeClient();
});

it('can fetch all favorites', function () {
    $favorites = $this->client->favorites()->get();

    $this->assertTrue(is_array($favorites));
    $this->assertTrue(count($favorites) > 0);
});

it('can fetch specific group of favorites', function () {
    $ids = [7, 8, 9];

    $favorites = $this->client->favorites()->get($ids);

    $this->assertTrue(is_array($favorites));
    $this->assertTrue(count($favorites) === count($ids));
});

it('can find a single favorite', function () {
    $id = 7;

    $favorites = $this->client->favorites()->find($id)->toArray();

    $this->assertTrue(is_array($favorites));
    $this->assertTrue(array_key_exists('id', $favorites));
});

it('can create a favorite', function () {
    $data = ['name' => 'test favorite', 'icon' => 'house'];

    $favorite = $this->client->favorites()->create($data);

    $this->assertTrue(is_array($favorite));
    $this->assertTrue($favorite['name'] === $data['name']);
});

it('can update a favorite', function () {
    $data = ['name' => 'test favorite update', 'icon' => 'home'];

    $favorites = $this->client->favorites()->update(7, $data);

    $this->assertTrue(is_array($favorites));
    $this->assertTrue($favorites['name'] === $data['name']);
});

it('can delete a favorite', function () {
    $favorites = $this->client->favorites()->get();

    $favorites = array_reverse($favorites);
    $response = $this->client->favorites()->delete($favorites[0]['id']);

    $this->assertTrue(is_null($response));
});
