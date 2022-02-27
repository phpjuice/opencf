<?php

use OpenCF\Algorithms\Slopeone\Predictor;
use OpenCF\Algorithms\Slopeone\WeightedSlopeone;
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

test('get prediction with slopeone', function () {
    $scheme = new WeightedSlopeone($this->dataset);
    $scheme->buildModel();
    $pred = new Predictor($this->dataset, $scheme->getModel(), new Vector());

    $u = [
        'Item1' => 0.4,
    ];
    expect($pred->getPrediction($u, 'Item2'))->toEqual(0.25);
    expect($pred->getPrediction($u, 'Item3'))->toEqual(0.23);
    expect($pred->getPrediction($u, 'Item4'))->toEqual(0.1);

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

    expect($pred->getPrediction($u1, 'Item4'))->toEqual(0.26);
    expect($pred->getPrediction($u2, 'Item2'))->toEqual(0.60);
    expect($pred->getPrediction($u3, 'Item1'))->toEqual(0.77);
});
