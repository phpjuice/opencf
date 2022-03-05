<?php

use OpenCF\Algorithms\Similarity\Cosine;
use OpenCF\Algorithms\Similarity\WeightedCosine;
use OpenCF\Algorithms\Slopeone\WeightedSlopeone;
use OpenCF\Contracts\IRecommender;
use OpenCF\Exceptions\EmptyModelException;
use OpenCF\Exceptions\NotRegisteredRecommenderException;
use OpenCF\RecommenderService;

it('does not initialize with an empty dataset', function () {
    new RecommenderService([]);
})->throws(EmptyModelException::class);

it('does not register an unsupported recommender', function () {
    $dataset = [
        'item1' => ['rating1' => 4],
    ];
    $recommenderService = new RecommenderService($dataset);
    $recommenderService->getRecommender('Cosine');
})->throws(NotRegisteredRecommenderException::class);

it('registers a supported recommender', function () {
    $dataset = [
        'item1' => ['rating1' => 4],
    ];
    $recommenderService = new RecommenderService($dataset);

    // instance of cosine
    $class = new class() implements IRecommender {
        public function name(): string
        {
            return 'Test Recommender';
        }

        public function getModel(): array
        {
            return [];
        }

        public function buildModel(): IRecommender
        {
            return $this;
        }

        public function predict(array $userRatings): array
        {
            return [];
        }
    };
    $recommenderService->registerRecommender(get_class($class));

    // instance of weighted cosine
    $recommenderService->registerRecommender(WeightedCosine::class);
    expect($recommenderService->getRecommender(WeightedCosine::class))->toBeInstanceOf(WeightedCosine::class);

    // instance of weighted cosine
    $recommenderService->registerRecommender(WeightedSlopeone::class);
    expect($recommenderService->getRecommender(WeightedSlopeone::class))->toBeInstanceOf(WeightedSlopeone::class);
});

it('throws an exception when retrieving an invalid recommender', function () {
    $dataset = [
        'item1' => ['rating1' => 4],
    ];
    $recommenderService = new RecommenderService($dataset);
    $recommenderService->getRecommender('Invalid');
})->throws(NotRegisteredRecommenderException::class);

it('retrieves a registered recommender', function () {
    $dataset = [
        'item1' => ['rating1' => 4],
    ];
    $recommenderService = new RecommenderService($dataset);
    $recommenderService->registerRecommender(Cosine::class);
    $instance = $recommenderService->getRecommender(Cosine::class);
    expect($instance)->toBeInstanceOf(Cosine::class);
});

it('retrieves a registers all default recommenders', function () {
    $dataset = [
        'item1' => ['rating1' => 4],
    ];
    $recommenderService = new RecommenderService($dataset);

    $instance = $recommenderService->getRecommender(Cosine::class);
    expect($instance)->toBeInstanceOf(Cosine::class);

    $instance = $recommenderService->getRecommender(WeightedCosine::class);
    expect($instance)->toBeInstanceOf(WeightedCosine::class);

    $instance = $recommenderService->getRecommender(WeightedSlopeone::class);
    expect($instance)->toBeInstanceOf(WeightedSlopeone::class);
});
