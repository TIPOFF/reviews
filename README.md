# Laravel Package for tracking Google reviews

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tipoff/reviews.svg?style=flat-square)](https://packagist.org/packages/tipoff/reviews)
![Tests](https://github.com/tipoff/reviews/workflows/Tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/tipoff/reviews.svg?style=flat-square)](https://packagist.org/packages/tipoff/reviews)


This is where your description should go.

## Installation

You can install the package via composer:

```bash
composer require tipoff/reviews
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Tipoff\Reviews\ReviewsServiceProvider" --tag="reviews-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Tipoff\Reviews\ReviewsServiceProvider" --tag="reviews-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Models

We include the following models in this package:

**List of Models**

- Competitor
- Insight
- Key
- Review
- Snapshot

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Tipoff](https://github.com/tipoff)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
