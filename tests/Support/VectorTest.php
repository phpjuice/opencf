<?php

use OpenCF\Support\Vector;

beforeEach(function () {
    // construct a vector
    $this->vector = new Vector();
});

it('set scale method', function () {
    expect($this->vector->getScale())->toEqual(2);
    $this->vector->setScale(3);
    expect($this->vector->getScale())->toEqual(3);
});

it('constructor method', function () {
    $vector = new Vector(3);
    expect($vector->getScale())->toEqual(3);
    expect($vector->getMeanVector())->toEqual([]);

    $vector = new Vector(null, [1, 3, 3]);
    expect($vector->getScale())->toEqual(2);
    expect($vector->getMeanVector())->toEqual([1, 3, 3]);
});

it('is sparse method', function () {
    $xVector = [
        'item1' => 2,
        'item2' => 2,
        'item3' => 3,
    ];
    $yVector = [
        'item1' => 2,
        'item2' => 2,
    ];
    expect($this->vector->isSparse($xVector, $yVector))->toBeTrue();
    expect($this->vector->isSparse($xVector, $xVector))->toBeFalse();
});

it('intersect method', function () {
    $expected = [
        [
            'item1' => 2,
            'item2' => 2,
        ],
        [
            'item1' => 2,
            'item2' => 2,
        ],
    ];
    $xVector = [
        'item1' => 2,
        'item2' => 2,
        'item3' => 3,
    ];
    $yVector = [
        'item1' => 2,
        'item2' => 2,
        'item4' => 3,
    ];
    $results = $this->vector->intersect($xVector, $yVector);
    expect($results)->toEqual($expected);
});

it('dot product with compatible vectors', function () {
    $xVector = [
        'item1' => 5,
        'item2' => 4,
    ];

    $results = $this->vector->dotProduct($xVector, $xVector);
    expect($results)->toEqual(41);

    $xVector = [
        'item1' => 0.444,
        'item2' => 1.233,
    ];

    $this->vector->setScale(2);

    $results = $this->vector->dotProduct($xVector, $xVector);
    expect($results)->toEqual(1.72);
    expect($this->vector->dotProduct([], []))->toEqual(0);
});

it('dot product with mean vector', function () {
    $xVector = [
        'item1' => 1,
        'item2' => 0.2,
    ];

    $yVector = [
        'item1' => 0.5,
        'item2' => 0.4,
    ];

    $meanVector = [
        'item1' => 0.566666,
        'item2' => 0.5,
    ];

    $this->vector->setMeanVector($meanVector);
    $results = $this->vector->dotProduct($xVector, $yVector);
    expect($results)->toEqual(-0.00);
});

it('norm method', function () {
    $vector = [
        'item1' => 2,
        'item2' => 2,
    ];
    $results = $this->vector->norm($vector);
    expect($results)->toEqual(2.83);
});

it('norm method with mean', function () {
    $vector = [
        'item1' => 1,
        'item2' => 0.2,
    ];

    $meanVector = [
        'item1' => 0.56666,
        'item2' => 0.5,
    ];

    $this->vector->setMeanVector($meanVector);
    expect($this->vector->norm($vector))->toEqual(0.52);
});

it('sum method', function () {
    $vector = [
        'item1' => 2,
        'item2' => 2,
    ];
    expect($this->vector->sum($vector))->toEqual(4);
    expect($this->vector->sum([]))->toEqual(0);

    $vector = [
        'item1' => 0.5666666666,
        'item2' => 1.433333333,
    ];
    expect($this->vector->sum($vector))->toEqual(2);
});

it('average method', function () {
    $vector = [
        'item1' => 2,
        'item2' => 2,
    ];
    expect($this->vector->average($vector))->toEqual(2);
    expect($this->vector->average([]))->toEqual(0);

    $vector = [
        'item1' => 0.5666666666,
        'item2' => 1.433333333,
    ];
    expect($this->vector->average($vector))->toEqual(1);
});

it('diff method', function () {
    $x = [
        'item1' => 1,
        'item2' => 1,
        'item3' => 0.2,
    ];
    $y = [
        'item1' => 0.2,
        'item2' => 0.5,
        'item3' => 1,
    ];
    expect($this->vector->diff($x, $y))->toEqual(0.5);
    expect($this->vector->diff([], []))->toEqual(0);

    $x = [
        'item1' => 0.5666666666,
        'item2' => 1.433333333,
    ];

    $y = [
        'item1' => 0.23,
        'item2' => 1.76,
    ];
    expect($this->vector->diff($x, $x))->toEqual(0);
    expect($this->vector->diff($x, $y))->toEqual(0.01);
});

it('card method', function () {
    $x = [
        'item1' => 0.5,
        'item2' => 1.4,
        'item3' => 1.4,
    ];

    $y = [
        'item1' => 0.23,
        'item2' => 1.76,
        'item4' => 3.4,
    ];

    expect($this->vector->card($x, $y))->toEqual(2);
});

it('rmse method', function () {
    $x = [
        'item1' => 3,
        'item2' => 2,
        'item3' => 3,
    ];
    $y = [
        'item4' => 2,
        'item5' => 2,
        'item6' => 3,
    ];
    expect($this->vector->rmse($x, $y))->toEqual(0);
    expect($this->vector->rmse($x, $x))->toEqual(0);
    $x = [
        'item1' => 5,
    ];
    $y = [
        'item1' => 2.1,
    ];
    expect($this->vector->rmse($x, $y))->toEqual(2.9);
});
