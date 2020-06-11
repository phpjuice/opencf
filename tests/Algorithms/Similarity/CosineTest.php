<?php

namespace OpenCF\OpenCF\Tests\Algorithms\Similarity;

use OpenCF\OpenCF\Algorithms\Similarity\Cosine;
use PHPUnit\Framework\TestCase as TestCase;

class CosineTest extends TestCase
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
        $scheme = new Cosine($this->dataset);
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
      'Batman V Superman' => 1.5,
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
      'Avatar' => 2.48,
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
      'Iron Man' => 4.02,
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
      'Spider man' => 4.01,
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
      'Hulk' => 3.78,
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
      'Batman V Superman' => 3.74,
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
      'Avatar' => 3.18,
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
      'Iron Man' => 2.25,
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
      'Spider man' => 2.75,
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
      'Hulk' => 3.26,
    ];
        $this->assertEquals($expected, $scheme->predict($user10));
    }
}
