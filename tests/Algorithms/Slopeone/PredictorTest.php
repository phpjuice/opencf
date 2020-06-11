<?php

namespace OpenCF\OpenCF\Tests\Algorithms\Slopeone;

use OpenCF\OpenCF\Algorithms\Slopeone\Predictor;
use OpenCF\OpenCF\Algorithms\Slopeone\WeightedSlopeone;
use OpenCF\OpenCF\Support\Vector;
use PHPUnit\Framework\TestCase as TestCase;

class PredictorTest extends TestCase
{
    protected $dataset;

    public function __construct()
    {
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
    }

    public function testGetPredictionWithSlopeone()
    {
        $scheme = new WeightedSlopeone($this->dataset);
        $scheme->buildModel();
        $pred = new Predictor($this->dataset, $scheme->getModel(), new Vector());

        $u = [
      'Item1' => 0.4,
    ];
        $this->assertEquals(0.25, $pred->getPrediction($u, 'Item2'));
        $this->assertEquals(0.23, $pred->getPrediction($u, 'Item3'));
        $this->assertEquals(0.1, $pred->getPrediction($u, 'Item4'));

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

        $this->assertEquals(0.26, $pred->getPrediction($u1, 'Item4'));
        $this->assertEquals(0.60, $pred->getPrediction($u2, 'Item2'));
        $this->assertEquals(0.77, $pred->getPrediction($u3, 'Item1'));
    }
}
