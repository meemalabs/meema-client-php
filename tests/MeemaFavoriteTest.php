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
    $this->assertTrue(count($favorites['data']) === count($ids));
});

it('can find a single favorite', function () {
    $id = 7;

    $favorites = $this->client->favorites()->find($id)->toArray();

    $this->assertTrue(is_array($favorites));
    $this->assertTrue(count($favorites) === 1);
});

it('can create a favorite', function () {
    $data = ['name' => 'test favorite', 'icon' => 'house'];

    $favorite = $this->client->favorites()->create($data);

    $this->assertTrue(is_array($favorite));
    $this->assertTrue($favorite['data']['name'] === $data['name']);
});

it('can update a favorite', function () {
    $data = ['name' => 'test favorite update', 'icon' => 'home'];

    $favorites = $this->client->favorites()->update(7, $data);

    $this->assertTrue(is_array($favorites));
    $this->assertTrue($favorites['data']['name'] === $data['name']);
});

it('can delete a favorite', function () {
    $favorites = $this->client->tags()->get();

    $favorites = array_reverse($favorites['data']);
    $response = $this->client->tags()->delete($favorites[0]['id']);

    $this->assertTrue(is_null($response));
});
