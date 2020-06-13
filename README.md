# Laravel Sort and Filter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/amitavroy/laravel-sort-and-filter.svg?style=flat-square)](https://packagist.org/packages/amitavroy/laravel-sort-and-filter)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/amitavroy/laravel-sort-and-filter/run-tests?label=tests)](https://github.com/amitavroy/laravel-sort-and-filter/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/amitavroy/laravel-sort-and-filter.svg?style=flat-square)](https://packagist.org/packages/amitavroy/laravel-sort-and-filter)

This package allows you to sort, filter and even search Eloquent models using the Request object.

No need to write conditional code inside you controller to handle sort, filter or search parameters coming from front end through URL (for example from a Javascrpt application)

Just pass the request object and the sorting and filters should automatically work.

## Installation

You can install the package via composer:

```bash
composer require amitavroy/laravel-sort-and-filter
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Amitav\SortAndFilter\SortAndFilterServiceProvider" --tag="config"
```

## Usage

You can sort and/or filter on any model after adding the trait as shown below:

```php
User::query()
    ->sort($request)
    ->filter($request)
    ->get();
```

You can even search on any model as shown below:

```php
User::query()
    ->search($request)
    ->get();
```

NOTE: The search is going to be a database query and the package runs a like query. And hence, be careful about the number of string that you allow in validation before you send the request object for search. Internally, the query will be something like:

```mysql
SELECT * FROM user WHERE name LIKE "amit%";
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email reachme@amitavroy.com instead of using the issue tracker.

## Credits

-   [Amitav Roy](https://github.com/amitavroy)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
