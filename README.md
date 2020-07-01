# Laravel Sort and Filter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/amitavroy/laravel-sort-and-filter.svg?style=flat-square)](https://packagist.org/packages/amitavroy/laravel-sort-and-filter)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/amitavroy/laravel-sort-and-filter/run-tests?label=tests)](https://github.com/amitavroy/laravel-sort-and-filter/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/amitavroy/laravel-sort-and-filter.svg?style=flat-square)](https://packagist.org/packages/amitavroy/laravel-sort-and-filter)

This package allows you to sort and filter Eloquent models using Request object or custom array based configuration.

Don't need to write conditional code inside you controller to handle sort and filter coming from front end through URL (for example from a Javascrpt application)

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

This pacakge provides with a Trait which you need to use in any Model that you want to have the ability to sort, filter or search. For example, in the user model, you can add

```
use SortAndFilter;
```

Once done, you can add the sort, filter or search function to the Model inside a query and pass the request object directly as show below.

```php
User::query()
    ->sort($request)
    ->filter($request)
    ->get();
```

With this, you have the ability to pass paramters through URL like this:

```
http://localhost:8000?sortBy=name&sortOrder=desc
http://localhost:8000?filterBy=name&filterValue=Amitav
```

If you want to control which fields can be filtered and which fields can be sorted, then you can create a protected field in your model with name $sortable to control sort fields. And, create a protected field with name $filterable to control which fields can be used to filter.

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
