# Coming Soon - Meema.io API

This package contains a [Flysystem](https://flysystem.thephpleague.com/) adapter for Meema. Under the hood, the Meema API is used.

## Installation

You can install the package via composer:

``` bash
composer require meemaio/meema-api
```

## Usage

The first thing you need to do is get an authorization token at Meema.io. A token can be generated in the [App Console](https://meema.io/) for any Meema API app.

``` php
use League\Flysystem\Filesystem;
use Meema\Client;
use Meema\FlysystemMeema\MeemaAdapter;

$client = new Client($authorizationToken);

$adapter = new MeemaAdapter($client);

$filesystem = new Filesystem($adapter);
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email chris@cion.agency instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
