<?php

use OpenCF\Algorithms\Similarity\Similarity;
use OpenCF\Support\Vector;

test('get similarity', function () {
    $vector = new Vector();
    $algorithm = new Similarity($vector);
    $xVector = [
        'item1' => 1,
        'item2' => 1,
        'item3' => 0.2,
    ];
    $yVector = [
        'item1' => 0.2,
        'item2' => 0.5,
        'item3' => 1,
    ];
    $results = $algorithm->getSimilarity($xVector, $xVector);
    expect($results)->toEqual(1);

    $results = $algorithm->getSimilarity($xVector, $yVector);
    expect($results)->toEqual(0.55);

    $results = $algorithm->getSimilarity($xVector, $yVector);
    $this->assertNotEquals(1, $results);
});

test('get similarity with mean', function () {
    $vector = new Vector();
    $vector->setMeanVector([
        'item1' => 0.57,
        'item2' => 0.5,
    ]);
    $algorithm = new Similarity($vector);
    $xVector = [
        'item1' => 1,
        'item2' => 1,
    ];
    $yVector = [
        'item1' => 0.2,
        'item2' => 0.5,
    ];
    $results = $algorithm->getSimilarity($xVector, $yVector);
    expect($results)->toEqual(-0.66);
});
