<?php

use OpenCF\Algorithms\Similarity\WeightedCosine;

beforeEach(function () {
    $this->dataset = [
        'Batman V Superman' => [
            'User1' => 4,
            'User2' => 3,
            'User3' => 5,
            'User4' => 5,
            'User5' => 4,
            'User6' => 5,
            'User7' => 5,
            'User8' => 5,
            'User9' => 2,
            'User10' => 3,
        ],
        'Avatar' => [
            'User1' => 3,
            'User2' => 1,
            'User3' => 2,
            'User4' => 5,
            'User5' => 4,
            'User6' => 5,
            'User7' => 5,
            'User8' => 5,
            'User9' => 2,
            'User10' => 2,
        ],
        'Iron Man' => [
            'User1' => 3,
            'User2' => 5,
            'User3' => 5,
            'User4' => 3,
            'User5' => 4,
            'User6' => 4,
            'User7' => 3,
            'User8' => 2,
            'User9' => 4,
            'User10' => 3,
        ],
        'Spider man' => [
            'User1' => 2,
            'User2' => 5,
            'User3' => 3,
            'User4' => 3,
            'User5' => 4,
            'User6' => 5,
            'User7' => 5,
            'User8' => 5,
            'User9' => 4,
            'User10' => 1,
        ],
        'Hulk' => [
            'User1' => 5,
            'User2' => 5,
            'User3' => 5,
            'User4' => 3,
            'User5' => 4,
            'User6' => 5,
            'User7' => 3,
            'User8' => 3,
            'User9' => 1,
            'User10' => 3,
        ],
    ];
    // $this->dataset
});

it('returns correct predictions', function () {
    $scheme = new WeightedCosine($this->dataset);
    $scheme->buildModel();

    $user1 = [
        'Avatar' => 1,
        'Iron Man' => 2,
        'Spider man' => 1,
        'Hulk' => 2,
    ];
    $expected = [
        'Batman V Superman' => 1.82,
    ];
    expect($scheme->predict($user1))->toEqual($expected);

    $user2 = [
        'Batman V Superman' => 2,
        'Iron Man' => 4,
        'Spider man' => 3,
        'Hulk' => 1,
    ];
    $expected = [
        'Avatar' => 2.88,
    ];
    expect($scheme->predict($user2))->toEqual($expected);

    $user3 = [
        'Batman V Superman' => 5,
        'Avatar' => 3,
        'Spider man' => 5,
        'Hulk' => 3,
    ];
    $expected = [
        'Iron Man' => 4.17,
    ];
    expect($scheme->predict($user3))->toEqual($expected);

    $user4 = [
        'Batman V Superman' => 5,
        'Avatar' => 3,
        'Iron Man' => 4,
        'Hulk' => 4,
    ];
    $expected = [
        'Spider man' => 4.41,
    ];
    expect($scheme->predict($user4))->toEqual($expected);

    $user5 = [
        'Batman V Superman' => 5,
        'Avatar' => 3,
        'Iron Man' => 4,
        'Spider man' => 3,
    ];
    $expected = [
        'Hulk' => 2.78,
    ];
    expect($scheme->predict($user5))->toEqual($expected);

    $user6 = [
        'Avatar' => 4,
        'Iron Man' => 5,
        'Spider man' => 3,
        'Hulk' => 3,
    ];
    $expected = [
        'Batman V Superman' => 4.04,
    ];
    expect($scheme->predict($user6))->toEqual($expected);

    $user7 = [
        'Batman V Superman' => 1,
        'Iron Man' => 5,
        'Spider man' => 4,
        'Hulk' => 3,
    ];
    $expected = [
        'Avatar' => 5.08,
    ];
    expect($scheme->predict($user7))->toEqual($expected);

    $user8 = [
        'Batman V Superman' => 3,
        'Avatar' => 2,
        'Spider man' => 2,
        'Hulk' => 2,
    ];
    $expected = [
        'Iron Man' => 2.56,
    ];
    expect($scheme->predict($user8))->toEqual($expected);

    $user8 = [
        'Batman V Superman' => 2,
        'Avatar' => 4,
        'Iron Man' => 3,
        'Hulk' => 2,
    ];
    $expected = [
        'Spider man' => 2.08,
    ];
    expect($scheme->predict($user8))->toEqual($expected);

    $user10 = [
        'Batman V Superman' => 4,
        'Avatar' => 2,
        'Iron Man' => 2,
        'Spider man' => 5,
    ];
    $expected = [
        'Hulk' => 4.01,
    ];
    expect($scheme->predict($user10))->toEqual($expected);
});

/**
 * @throws ReflectionException
 */
it('transposes the ratings matrix', function () {
    $matrix = [
        'Item1' => [
            'Rating1' => 1,
            'Rating2' => 1,
        ],
        'Item2' => [
            'Rating1' => 0.5,
            'Rating2' => 0.4,
        ],
    ];

    $expectedMatrix = [
        'Rating1' => [
            'Item1' => 1,
            'Item2' => 0.5,
        ],
        'Rating2' => [
            'Item1' => 1,
            'Item2' => 0.4,
        ],
    ];

    $transpose = getMethod('transpose');
    $weightedCosine = new WeightedCosine($matrix);
    $results = $transpose->invokeArgs($weightedCosine, [null]);

    expect($expectedMatrix)->toEqual($results);
});

/**
 * @param  string  $name
 * @return ReflectionMethod
 * @throws ReflectionException
 */
function getMethod(string $name): ReflectionMethod
{
    $class = new ReflectionClass(WeightedCosine::class);
    $method = $class->getMethod($name);
    $method->setAccessible(true);

    return $method;
}
