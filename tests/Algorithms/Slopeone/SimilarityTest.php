<?php

use OpenCF\Algorithms\Slopeone\Similarity;
use OpenCF\Support\Vector;

test('calculates similarity between items with deviation', function () {
    $vector = new Vector();
    $algorithm = new Similarity($vector);
    $xVector = [
        'item1' => 1,
        'item2' => 0.2,
    ];
    $yVector = [
        'item1' => 0.5,
        'item2' => 0.4,
    ];

    $results = $algorithm->getSimilarity($xVector, $yVector);
    expect($results)->toEqual(0.15);

    $results = $algorithm->getSimilarity($xVector, $xVector);
    expect($results)->toEqual(0);

    $this->expectException(InvalidArgumentException::class);
    $algorithm->getSimilarity([], []);
});
