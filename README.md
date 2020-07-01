# Laravel Sort and Filter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/amitavroy/laravel-sort-and-filter.svg?style=flat-square)](https://packagist.org/packages/amitavroy/laravel-sort-and-filter)
![Tests](https://github.com/amitavroy/laravel-sort-and-filter/workflows/Tests/badge.svg)
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

This pacakge provides with a Trait which you need to use in any Model that you want to have the ability to sort, filter or search. For example, in the user model, you need to add

```
use SortAndFilter;
```

Once done, you can add the sort, filter or search function to the Model inside a query and pass the request object directly as show below.

You can sort and/or filter on any model after adding the trait as shown below:

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

If you want to control which fields can be filtered and which fields can be sorted, then you can create a protected field in your model with name **\$sortable** to control sort fields. And, create a protected field with name **\$filterable** to control which fields can be used to filter.

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
