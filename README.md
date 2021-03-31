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
    <a href="https://meema.io/docs" target="_blank">FAQ</a>  •
    <a href="https://meema.io/support" target="_blank">Support</a>
</p>

## 🐑 Features

- Thin & minimal low-level HTTP client to interact with Meema's API
- Supports php `^5.*`.

## 💡 Usage

First, install Meema PHP API Client via the [composer](https://getcomposer.org/) package manager:

```bash
composer require meema/meema-client-php
```

Then, wip

```php
$client->folders()->get([1, 2, 3]);
$client->folders()->delete(1, 2, 3);
$client->folders(1)->update(['name' = 'New Folder Name']);
$client->folders([1, 2, 3])->media()->get();
$client->tags()->get();
$client->tags()->delete(1, 2, 3);
$client->tags(1)->update(['name' = 'New Tag Name']);
$client->tags([1, 2, 3])->media()->get();
// need to the same for following resources
$client->favorites()->get();
$client->media()->get();
$client->teams()->get();

$client->media()->get(); 
$client->media()->search($q);
$client->media()->metadata()->get();

$client->folders()->get(); 
$client->folders()->search($q); 
```

For the full documentation, visit the **[Meema PHP API Client](https://meema.io/docs/)**.

## ❓ Troubleshooting

Encountering an issue? Before reaching out to support, we recommend heading to our [FAQ](https://meema.io/docs/) where you will find answers for the most common issues and gotchas with the client.

## 📄 License

Meema PHP API Client is an open-sourced software licensed under the [MIT license](LICENSE.md).
