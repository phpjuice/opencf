<?php

use OpenCF\Algorithms\Similarity\Cosine;
use OpenCF\Algorithms\Similarity\Predictor;
use OpenCF\Support\Vector;

beforeEach(function () {
    $this->dataset = [
        'Item1' => [
            'Rating1' => 1,
            'Rating2' => 1,
            'Rating3' => 0.2,
        ],
        'Item2' => [
            'Rating1' => 0.5,
            'Rating3' => 0.4,
            'Rating4' => 0.9,
        ],
        'Item3' => [
            'Rating1' => 0.2,
            'Rating2' => 0.5,
            'Rating3' => 1,
            'Rating4' => 0.4,
        ],
        'Item4' => [
            'Rating2' => 0.2,
            'Rating3' => 0.4,
            'Rating4' => 0.5,
        ],
    ];
});

it('returns correct prediction for a single item', function () {
    $cosine = new Cosine($this->dataset);
    $cosine->buildModel();
    $pred = new Predictor($this->dataset, $cosine->getModel(), new Vector());

    $u1 = [
        'Item1' => 1,
        'Item2' => 0.5,
        'Item3' => 0.2,
    ];
    $u2 = [
        'Item1' => 1,
        'Item3' => 0.5,
        'Item4' => 0.2,
    ];
    $u3 = [
        'Item2' => 0.9,
        'Item3' => 0.4,
        'Item4' => 0.5,
    ];
    expect($pred->getPrediction($u1, 'Item4'))->toBe(0.52);
    expect($pred->getPrediction($u2, 'Item2'))->toBe(0.56);
    expect($pred->getPrediction($u3, 'Item1'))->toBe(0.65);
});
