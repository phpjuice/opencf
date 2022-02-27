<?php

use OpenCF\Algorithms\Similarity\Cosine;
use OpenCF\Algorithms\Similarity\WeightedCosine;
use OpenCF\Algorithms\Slopeone\WeightedSlopeone;
use OpenCF\Exceptions\EmptyDatasetException;
use OpenCF\Exceptions\NotRegisteredRecommenderException;
use OpenCF\RecommenderService;

test('constructor with empty dataset', function () {
    $this->expectException(EmptyDatasetException::class);
    new RecommenderService([]);
});

test('register not supported recommender', function () {
    $this->expectException(NotRegisteredRecommenderException::class);
    $dataset = [
        'item1' => ['rating1' => 4],
    ];
    $recommenderService = new RecommenderService($dataset);
    $recommenderService->getRecommender('Cosine');
});

test('register supported recommender', function () {
    $dataset = [
        'item1' => ['rating1' => 4],
    ];
    $recommenderService = new RecommenderService($dataset);

    // instance of cosine
    $recommenderService->registerRecommender('Cosine');
    expect($recommenderService->getRecommender('Cosine'))->toBeInstanceOf(Cosine::class);

    // instance of weighted cosine
    $recommenderService->registerRecommender('WeightedCosine');
    expect($recommenderService->getRecommender('WeightedCosine'))->toBeInstanceOf(WeightedCosine::class);

    // instance of weighted cosine
    $recommenderService->registerRecommender('WeightedSlopeone');
    expect($recommenderService->getRecommender('WeightedSlopeone'))->toBeInstanceOf(WeightedSlopeone::class);
});

test('get recommender', function () {
    $this->expectException(NotRegisteredRecommenderException::class);
    $dataset = [
        'item1' => ['rating1' => 4],
    ];
    $recommenderService = new RecommenderService($dataset);
    $recommenderService->getRecommender('Cosine');
});

test('get registered recommender', function () {
    $dataset = [
        'item1' => ['rating1' => 4],
    ];
    $recommenderService = new RecommenderService($dataset);
    $recommenderService->registerRecommender('Cosine');
    $instance = $recommenderService->getRecommender('Cosine');
    expect($instance)->toBeInstanceOf(Cosine::class);
});
