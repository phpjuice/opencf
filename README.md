# OpenCF

[![tests](https://github.com/phpjuice/opencf/actions/workflows/php.yml/badge.svg?branch=main)](https://github.com/phpjuice/opencf/actions/workflows/php.yml)
[![packagist](https://github.com/phpjuice/opencf/actions/workflows/cron.yml/badge.svg?branch=main)](https://github.com/phpjuice/opencf/actions/workflows/cron.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/60b1fac54adddd5a4e12/maintainability)](https://codeclimate.com/github/phpjuice/opencf/maintainability)
[![Latest Stable Version](http://poser.pugx.org/phpjuice/opencf/v)](https://packagist.org/packages/phpjuice/opencf)
[![Total Downloads](http://poser.pugx.org/phpjuice/opencf/downloads)](https://packagist.org/packages/phpjuice/opencf)
[![License](http://poser.pugx.org/phpjuice/opencf/license)](https://packagist.org/packages/phpjuice/opencf)

PHP implementation of the (Weighted Slopeone,Cosine, Weighted Cosine) rating-based collaborative filtering schemes.

To learn all about it, head over to the extensive [documentation](https://phpjuice.gitbook.io/opencf).

## Installation

OpenCF Package requires `PHP 7.4` or higher.

> **INFO:** If you are using an older version of php this package will not function correctly.

The supported way of installing `OpenCF` package is via Composer.

```bash
composer require phpjuice/opencf
```

## Usage

OpenCF Package is designed to be very simple and straightforward to use. All you have to do is:

1. Load a training set (dataset)
2. Predict future ratings using a recommender. (Weighted Slopeone,Cosine, Weighted Cosine)

### Create Recommender Service

The `OpenCF` recommender service is created by direct instantiation:

```php
use OpenCF\RecommenderService;

// Create an instance
$recommenderService = new RecommenderService($dataset);
```

### Adding dataset

Adding a dataset to the recommender can be done using the constructor or can be easily done by providing an array of
users ratings via the `setDataset()` method:

```php
$dataset = [
    "squid" => [
        "user1" => 1,
        "user2" => 1,
        "user3" => 0.2,
    ],
    "cuttlefish" => [
        "user1" => 0.5,
        "user3" => 0.4,
        "user4" => 0.9,
    ],
    "octopus" => [
        "user1" => 0.2,
        "user2" => 0.5,
        "user3" => 1,
        "user4" => 0.4,
    ],
    "nautilus" => [
        "user2" => 0.2,
        "user3" => 0.4,
        "user4" => 0.5,
    ],
];

$recommenderService->setDataset($dataset);
```

### Getting Predictions

All you have to do to predict ratings for a new user is to retrieve an engine from the recommender service and & run
the `predict()` method.

```php
// Get a recommender
$recommender = $recommenderService->cosine(); // Cosine recommender
// OR
$recommender = $recommenderService->weightedCosine(); // WeightedCosine recommender
// OR
$recommender = $recommenderService->weightedSlopeone(); // WeightedSlopeone recommender

// Predict future ratings
$results = $recommender->predict([
    "squid" => 0.4
]);
```

This should produce the following results when using `WeightedSlopeone` recommender

```php
[
  "cuttlefish" => 0.25,
  "octopus" => 0.23,
  "nautilus" => 0.1
];
```

## Running the tests

you can easily run tests using composer

```bash
composer test
```

## Built With

- [PHP](http://www.php.net) - The programing language used
- [Composer](https://getcomposer.org) - Dependency Management
- [Pest](https://pestphp.com) - An elegant PHP Testing Framework

## Changelog

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING.md](./CONTRIBUTING.md) for details and a todo list.

## Security

If you discover any security related issues, please email author instead of using the issue tracker.

## Credits

- [Daniel Lemire](https://github.com/lemire)
- [SlopeOne Predictors for Online Rating-Based Collaborative Filtering](https://www.researchgate.net/publication/1960789_Slope_One_Predictors_for_Online_Rating-Based_Collaborative_Filtering)
- [Distance Weighted Cosine Similarity](https://link.springer.com/chapter/10.1007/978-3-642-41278-3_74)

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see
the [tags on this repository](https://github.com/PHPJuice/opencf/tags).

## License

license. Please see the [Licence](https://github.com/phpjuice/opencf/blob/main/LICENSE) for more information.

[![tests](https://github.com/phpjuice/opencf/actions/workflows/php.yml/badge.svg?branch=main)](https://github.com/phpjuice/opencf/actions/workflows/php.yml)
[![packagist](https://github.com/phpjuice/opencf/actions/workflows/cron.yml/badge.svg?branch=main)](https://github.com/phpjuice/opencf/actions/workflows/cron.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/60b1fac54adddd5a4e12/maintainability)](https://codeclimate.com/github/phpjuice/opencf/maintainability)
[![Latest Stable Version](http://poser.pugx.org/phpjuice/opencf/v)](https://packagist.org/packages/phpjuice/opencf)
[![Total Downloads](http://poser.pugx.org/phpjuice/opencf/downloads)](https://packagist.org/packages/phpjuice/opencf)
[![License](http://poser.pugx.org/phpjuice/opencf/license)](https://packagist.org/packages/phpjuice/opencf)
