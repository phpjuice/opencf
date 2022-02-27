# OpenCF

![Tests](https://github.com/phpjuice/opencf/workflows/Tests/badge.svg?branch=main)
[![Latest Stable Version](http://poser.pugx.org/phpjuice/opencf/v)](https://packagist.org/packages/phpjuice/opencf)
[![Total Downloads](http://poser.pugx.org/phpjuice/opencf/downloads)](https://packagist.org/packages/phpjuice/opencf)
[![License](http://poser.pugx.org/phpjuice/opencf/license)](https://packagist.org/packages/phpjuice/opencf)

PHP implementation of the (Weighted Slopeone,Cosine, Weighted Cosine) rating-based collaborative filtering schemes.

## Installation

OpenCF Package requires `PHP 7.4` or higher.

> **INFO:** If you are using an older version of php this package will not function correctly.

The supported way of installing `OpenCF` package is via Composer.

```bash
composer require phpjuice/opencf
```

## Usage

OpenCF Package is designed to be very simple and straightforward to use. All you have to do is to load rating data, then
predict future ratings based on the training set provided.

### Create Recommender Service

The `OpenCF` recommender service is created by direct instantiation:

```php
use OpenCF\RecommenderService;

// Create an instance
$recommenderService = new RecommenderService($dataset);
```

### Registering a recommendation engine

The recommender service support's 3 recommendation engines (Weighted Slopeone,Cosine, Weighted Cosine).

#### Cosine

```php
// Register a `Cosine` recommendation engine
$recommenderService->registerRecommender('Cosine');
$recommenderService->getRecommender('Cosine'); // OpenCF\Algorithms\Similarity\Cosine::class
```

#### Weighted Cosine

```php
// Register a `Weighted Cosine` recommendation engine
$recommenderService->registerRecommender('WeightedCosine');
$recommenderService->getRecommender('WeightedCosine'); // OpenCF\Algorithms\Similarity\WeightedCosine::class
```

#### Weighted Slopeone

```php
// Register a `Weighted Slopeone` recommendation engine
$recommenderService->registerRecommender('WeightedSlopeone');
$recommenderService->getRecommender('WeightedSlopeone'); // OpenCF\Algorithms\Slopeone\WeightedSlopeone::class
```

### Adding dataset

Adding a dataset to the recommender can be done using the constructor or can be easily done by providing an array of
users ratings via the `setDataset()` method:

```php

$dataset =[
  [
    "squid" => 1,
    "cuttlefish" => 0.5,
    "octopus" => 0.2
  ],
  [
    "squid" => 1,
    "octopus" => 0.5,
    "nautilus" => 0.2
  ],
  [
    "squid" => 0.2,
    "octopus" => 1,
    "cuttlefish" => 0.4,
    "nautilus" => 0.4
  ],
  [
    "cuttlefish" => 0.9,
    "octopus" => 0.4,
    "nautilus" => 0.5
  ]
];

$recommenderService->setDataset($dataset);
```

### Getting Predictions

All you have to do to predict ratings for a new user is to retrieve an engine from the recommender service and
run `predict()` method.

```php
// Get engine
$weightedSlopeone = $recommenderService->getRecommender('WeightedSlopeone');

// Build model
$weightedSlopeone->buildModel();

// Get predictions
$results = $weightedSlopeone->predict([
    "squid" => 0.4
]);
```

This should produce the following results

```php
[
  "cuttlefish"=>0.25,
  "octopus"=>0.23333333333333,
  "nautilus"=>0.1
];
```

## Running the tests

you can easily run tests using composer

```bash
$ composer test
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

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see
the [tags on this repository](https://github.com/PHPJuice/opencf/tags).

## License

license. Please see the [Licence](https://github.com/phpjuice/opencf/blob/main/LICENSE) for more information.

![Tests](https://github.com/phpjuice/opencf/workflows/Tests/badge.svg?branch=main)
[![Latest Stable Version](http://poser.pugx.org/phpjuice/opencf/v)](https://packagist.org/packages/phpjuice/opencf)
[![Total Downloads](http://poser.pugx.org/phpjuice/opencf/downloads)](https://packagist.org/packages/phpjuice/opencf)
[![License](http://poser.pugx.org/phpjuice/opencf/license)](https://packagist.org/packages/phpjuice/opencf)
