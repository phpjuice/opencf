# OpenCF

[![tests](https://github.com/phpjuice/opencf/actions/workflows/php.yml/badge.svg?branch=main)](https://github.com/phpjuice/opencf/actions/workflows/php.yml)
[![packagist](https://github.com/phpjuice/opencf/actions/workflows/cron.yml/badge.svg?branch=main)](https://github.com/phpjuice/opencf/actions/workflows/cron.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/60b1fac54adddd5a4e12/maintainability)](https://codeclimate.com/github/phpjuice/opencf/maintainability)
[![Latest Stable Version](http://poser.pugx.org/phpjuice/opencf/v)](https://packagist.org/packages/phpjuice/opencf)
[![Total Downloads](http://poser.pugx.org/phpjuice/opencf/downloads)](https://packagist.org/packages/phpjuice/opencf)
[![License](http://poser.pugx.org/phpjuice/opencf/license)](https://packagist.org/packages/phpjuice/opencf)

PHP implementation of the (Weighted Slopeone,Cosine, Weighted Cosine) rating-based collaborative filtering schemes.

## Usage

OpenCF Package is designed to be very simple and straightforward to use. All you have to do is:

1. Load a training set (dataset)
2. Predict future ratings using a recommender. (Weighted Slopeone,Cosine, Weighted Cosine)

### Create Recommender Service

The `OpenCF` recommender service is created by direct instantiation:

```php
use OpenCF\RecommenderService;

// Training Dataset
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

// Create a recommender service instance
$recommenderService = new RecommenderService($dataset);

// Retrieve a recommender (Weighted Slopeone)
$recommender = $recommenderService->weightedSlopeone();

// Predict future ratings
$results = $recommender->predict([
    "squid" => 0.4
]);
```

This should produce the following results:

```php
[
  "cuttlefish" => 0.25,
  "octopus" => 0.23,
  "nautilus" => 0.1
];
```
