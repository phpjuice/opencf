<?php

namespace OpenCF\Tests\Algorithms\Similarity;

use OpenCF\Algorithms\Similarity\WeightedCosine;
use PHPUnit\Framework\TestCase as TestCase;

class WeightedCosineTest extends TestCase
{
    protected $dataset;

    public function __construct()
    {
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
        ]; // $this->dataset
    }

    public function testSlopeoneSchemePredictMethod()
    {
        $scheme = new WeightedCosine($this->dataset);
        $scheme->buildModel();

        /**
         * @var
         */
        $user1 = [
            'Avatar' => 1,
            'Iron Man' => 2,
            'Spider man' => 1,
            'Hulk' => 2,
        ];
        $expected = [
            'Batman V Superman' => 1.82,
        ];
        $this->assertEquals($expected, $scheme->predict($user1));

        /**
         * @var
         */
        $user2 = [
            'Batman V Superman' => 2,
            'Iron Man' => 4,
            'Spider man' => 3,
            'Hulk' => 1,
        ];
        $expected = [
            'Avatar' => 2.88,
        ];
        $this->assertEquals($expected, $scheme->predict($user2));

        /**
         * @var
         */
        $user3 = [
            'Batman V Superman' => 5,
            'Avatar' => 3,
            'Spider man' => 5,
            'Hulk' => 3,
        ];
        $expected = [
            'Iron Man' => 4.17,
        ];
        $this->assertEquals($expected, $scheme->predict($user3));

        /**
         * @var
         */
        $user4 = [
            'Batman V Superman' => 5,
            'Avatar' => 3,
            'Iron Man' => 4,
            'Hulk' => 4,
        ];
        $expected = [
            'Spider man' => 4.41,
        ];
        $this->assertEquals($expected, $scheme->predict($user4));

        /**
         * @var
         */
        $user5 = [
            'Batman V Superman' => 5,
            'Avatar' => 3,
            'Iron Man' => 4,
            'Spider man' => 3,
        ];
        $expected = [
            'Hulk' => 2.78,
        ];
        $this->assertEquals($expected, $scheme->predict($user5));

        /**
         * @var
         */
        $user6 = [
            'Avatar' => 4,
            'Iron Man' => 5,
            'Spider man' => 3,
            'Hulk' => 3,
        ];
        $expected = [
            'Batman V Superman' => 4.04,
        ];
        $this->assertEquals($expected, $scheme->predict($user6));

        /**
         * @var
         */
        $user7 = [
            'Batman V Superman' => 1,
            'Iron Man' => 5,
            'Spider man' => 4,
            'Hulk' => 3,
        ];
        $expected = [
            'Avatar' => 5.08,
        ];
        $this->assertEquals($expected, $scheme->predict($user7));

        /**
         * @var
         */
        $user8 = [
            'Batman V Superman' => 3,
            'Avatar' => 2,
            'Spider man' => 2,
            'Hulk' => 2,
        ];
        $expected = [
            'Iron Man' => 2.56,
        ];
        $this->assertEquals($expected, $scheme->predict($user8));

        /**
         * @var
         */
        $user8 = [
            'Batman V Superman' => 2,
            'Avatar' => 4,
            'Iron Man' => 3,
            'Hulk' => 2,
        ];
        $expected = [
            'Spider man' => 2.08,
        ];
        $this->assertEquals($expected, $scheme->predict($user8));

        /**
         * @var
         */
        $user10 = [
            'Batman V Superman' => 4,
            'Avatar' => 2,
            'Iron Man' => 2,
            'Spider man' => 5,
        ];
        $expected = [
            'Hulk' => 4.01,
        ];
        $this->assertEquals($expected, $scheme->predict($user10));
    }

    protected static function getMethod($name)
    {
        $class = new \ReflectionClass(WeightedCosine::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    public function testTransposeMatrix()
    {
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

        $transpose = self::getMethod('transpose');
        $weightedCosine = new WeightedCosine($matrix);
        $results = $transpose
              ->invokeArgs($weightedCosine, [null]);

        $this->assertEquals(
            $results,
            $expectedMatrix
        );
    }
}
