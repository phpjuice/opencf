<?php

use OpenCF\RecommenderService;

it('tests predictions with real data', function () {
    $dataset = transpose([
        "user1" => [
            "squid" => 1,
            "cuttlefish" => 0.5,
            "octopus" => 0.2,
        ],
        "user2" => [
            "squid" => 1,
            "octopus" => 0.5,
            "nautilus" => 0.2,
        ],
        "user3" => [
            "squid" => 0.2,
            "octopus" => 1,
            "cuttlefish" => 0.4,
            "nautilus" => 0.4,
        ],
        "user4" => [
            "cuttlefish" => 0.9,
            "octopus" => 0.4,
            "nautilus" => 0.5,
        ],
    ]);

    // Create an instance
    $recommenderService = new RecommenderService($dataset);

    // Get a recommender
    $recommender = $recommenderService->weightedSlopeone();

    // Predict future ratings
    $results = $recommender->predict([
        'squid' => 0.4,
    ]);

    expect($results)->toBe([
        "cuttlefish" => 0.25,
        "octopus" => 0.23,
        "nautilus" => 0.1,
    ]);
});
