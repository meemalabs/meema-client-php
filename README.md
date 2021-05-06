<p align="center">
  <a href="https://meema.io">
    <img alt="Meema for PHP" src="https://raw.githubusercontent.com/meema/meemasearch-client-common/master/banners/php.png" >
  </a>

<h4 align="center">The most simple way to integrate <a href="https://meema.io" target="_blank">Meema</a> and your PHP project</h4>

<p align="center">
    <a href="https://scrutinizer-ci.com/g/meemalabs/meema-client-php/badges/quality-score.png?b=main"><img src="https://scrutinizer-ci.com/g/meemalabs/meema-client-php/badges/quality-score.png?b=main" alt="Scrutinizer" /></a>
    <a href="https://packagist.org/packages/meema/meema-client-php"><img src="https://poser.pugx.org/meema/meema-client-php/d/total.svg" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/meema/meema-client-php"><img src="https://poser.pugx.org/meema/meema-client-php/v/stable.svg" alt="Latest Version"></a>
    <a href="https://packagist.org/packages/meema/meema-client-php"><img src="https://poser.pugx.org/meema/meema-client-php/license.svg" alt="License"></a>
</p>

<p align="center">
    <a href="https://www.meema.com/doc/api-client/getting-started/install/php/" target="_blank">Documentation</a>  •
    <a href="https://github.com/meema/laravel-meema" target="_blank">Laravel</a>  •
    <a href="http://stackoverflow.com/questions/tagged/meema" target="_blank">Stack Overflow</a>  •
    <a href="https://github.com/meema/meema-client-php/issues" target="_blank">Report a bug</a>  •
    <a href="https://docs.meema.io" target="_blank">FAQ</a>  •
    <a href="https://discord.meema.io" target="_blank">Discord</a>
</p>

## 🐑 Features

- Most simple way to implement a fully-functional media management system
- Thin & minimal package to interact with Meema's API
- Supports php `^5.*`

## 💡 Usage

First, install Meema PHP API Client via the [composer](https://getcomposer.org/) package manager:

```bash
composer require meema/meema-client-php
```

Then initialize the Client

```php
use Meema\MeemaClient\Client

$client = new Client($meemaApiKey);
```
Using the `Media` model

```php
$client->media()->create('New media name');
$client->media()->get();

// Specific uuids
$client->media()->get('11a283ed-a64e-424a-aefc-6aa98971d529', '1556fcb8-693e-4431-8b16-3b2b7bb8fcc7');
$client->media()->search('media-name');

// This will return a Response instance
$media = $client->media()->find('11a283ed-a64e-424a-aefc-6aa98971d529');

// So that you can chain other methods that require an id.
$media->update('updated-media-name')
$media->delete();
$media->archive();
$media->unarchive();
$media->makePrivate();
$media->makePublic();
$media->duplicate();

// Relationships with other models.
// Continuing with the chaining methods we used earlier.
$media->folders()->get();
$media->folders()->create('New folder name');
$media->folders()->delete('11a283ed-a64e-424a-aefc-6aa98971d529');
$media->tags()->get();
$media->tags()->associate(['name' => 'Tag Name']);
$media->tags()->disassociate(['name' => 'Tag Name']);
```

Using the `Folder` model

```php
$client->folders()->create('New folder name');
$client->folders()->get();

// Specific uuids
$client->folders()->get('11a283ed-a64e-424a-aefc-6aa98971d529', '1556fcb8-693e-4431-8b16-3b2b7bb8fcc7');
$client->folders()->search('folder-name');

// This will return a Response instance
$folder = $client->folders()->find('11a283ed-a64e-424a-aefc-6aa98971d529');

// So that you can chain other methods that require an id.
$folder->update('updated-folder-name')
$folder->delete();
$folder->archive();
$folder->unarchive();
$folder->duplicate();

// Relationships with other models.
// Continuing with the chaining methods we used earlier.
$folder->media()->get();
$folder->tags()->get();
$folder->tags()->associate(['tag_id' => 7]);
$folder->tags()->disassociate(['tag_id' => 7]);
```

Using the `Tag` model

```php
$client->tags()->get();

// Specific ids
$client->tags()->get(1, 2, 3);

// This will return a Response instance
$tag = $client->tags()->find(1);

// So that you can chain other methods that require an id.
$tag->update('red-500'); // You will have to use tailwind CSS color palletes.
$tag->delete();
$tag->media()->get();
```

Using the `Favorite` model

```php
$client->favorites()->create(['name' => 'New Favorite Name', 'icon' => 'favorite-icon']);
$client->favorites()->get();

// Specific ids
$client->favorites()->get(1,2,3);

// This will return a Response instance
$favorite = $client->favorites()->find(1);

// So that you can chain other methods that require an id.
$favorite->update(['name' => 'Updated Favorite Name', 'icon' => 'updated-favorite-icon']);
$favorite->delete();
```

Using the `Storage` model

```php
$client->storage()->upload('path/to/local/media/file'); 
$client->storage()->getMetadata('meema/directory/to/file.jpg');

$client->storage()->setVisibility('meema/directory/to/file.jpg', 'private'); // Or 'public'
$client->storage()->has('meema/directory/to/file.jpg');
$client->storage()->delete('meema/directory/to/file.jpg');
$client->storage()->copy('meema/directory/to/file.jpg', 'meema/directory/to/copied-file.jpg');
$client->storage()->rename('meema/directory/to/file.jpg', 'meema/directory/to/renamed-file.jpg');

$client->storage()->listContents('meema/directory');
$client->storage()->makeDirectory('meema/directory/newDirectory');
```

For using the lamdba functions for sharp or imgix image manipulations, read more **[here](https://meema.io/docs/)**

For the full documentation, visit the **[Meema PHP API Client](https://meema.io/docs/)**.

## ❓ Troubleshooting

Encountering an issue? Before reaching out to support, we recommend heading to our [FAQ](https://meema.io/docs/) where you will find answers for the most common issues and gotchas with the client.

## 📄 License

Meema PHP API Client is an open-sourced software licensed under the [MIT license](LICENSE.md).
