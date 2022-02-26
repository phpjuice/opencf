<?php

namespace OpenCF\Tests\Support;

use InvalidArgumentException;
use OpenCF\Support\Vector;
use PHPUnit\Framework\TestCase as TestCase;

class VectorTest extends TestCase
{
    private $vector;

    public function __construct()
    {
        // construct a vector
        $this->vector = new Vector();
    }

    public function testSetScaleMethod()
    {
        $this->assertEquals(2, $this->vector->getScale());
        $this->vector->setScale(3);
        $this->assertEquals(3, $this->vector->getScale());
    }

    public function testConstructorMethod()
    {
        $vector = new Vector(3);
        $this->assertEquals(3, $vector->getScale());
        $this->assertEquals([], $vector->getMeanVector());

        $vector = new Vector(null, [1, 3, 3]);
        $this->assertEquals(2, $vector->getScale());
        $this->assertEquals([1, 3, 3], $vector->getMeanVector());

        $this->expectException(InvalidArgumentException::class);
        $this->vector->setScale([]);
        $this->vector->setScale('33');
        $this->vector->setScale(33);
    }

    public function testIsSparseMethod()
    {
        $xVector = [
            'item1' => 2,
            'item2' => 2,
            'item3' => 3,
        ];
        $yVector = [
            'item1' => 2,
            'item2' => 2,
        ];
        $this->assertTrue($this->vector->isSparse($xVector, $yVector));
        $this->assertFalse($this->vector->isSparse($xVector, $xVector));
    }

    public function testIntersectMethod()
    {
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
        $this->assertEquals($expected, $results);
    }

    public function testDotProductWithCompatibleVectors()
    {
        $xVector = [
            'item1' => 5,
            'item2' => 4,
        ];

        $results = $this->vector->dotProduct($xVector, $xVector);
        $this->assertEquals(41, $results);

        $xVector = [
            'item1' => 0.444,
            'item2' => 1.233,
        ];

        $this->vector->setScale(2);

        $results = $this->vector->dotProduct($xVector, $xVector);
        $this->assertEquals(1.72, $results);
        $this->assertEquals(0, $this->vector->dotProduct([], []));
    }

    public function testDotProductWithMeanVector()
    {
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
        $this->assertEquals(-0.00, $results);
    }

    public function testNormMethod()
    {
        $vector = [
            'item1' => 2,
            'item2' => 2,
        ];
        $results = $this->vector->norm($vector);
        $this->assertEquals(2.83, $results);
    }

    public function testNormMethodWithMean()
    {
        $vector = [
            'item1' => 1,
            'item2' => 0.2,
        ];

        $meanVector = [
            'item1' => 0.56666,
            'item2' => 0.5,
        ];

        $this->vector->setMeanVector($meanVector);
        $this->assertEquals(0.52, $this->vector->norm($vector));
    }

    public function testSumMethod()
    {
        $vector = [
            'item1' => 2,
            'item2' => 2,
        ];
        $this->assertEquals(4, $this->vector->sum($vector));
        $this->assertEquals(0, $this->vector->sum([]));

        $vector = [
            'item1' => 0.5666666666,
            'item2' => 1.433333333,
        ];
        $this->assertEquals(2, $this->vector->sum($vector));
    }

    public function testAverageMethod()
    {
        $vector = [
            'item1' => 2,
            'item2' => 2,
        ];
        $this->assertEquals(2, $this->vector->average($vector));
        $this->assertEquals(0, $this->vector->average([]));

        $vector = [
            'item1' => 0.5666666666,
            'item2' => 1.433333333,
        ];
        $this->assertEquals(1, $this->vector->average($vector));
    }

    public function testDiffMethod()
    {
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
        $this->assertEquals(0.5, $this->vector->diff($x, $y));
        $this->assertEquals(0, $this->vector->diff([], []));

        $x = [
            'item1' => 0.5666666666,
            'item2' => 1.433333333,
        ];

        $y = [
            'item1' => 0.23,
            'item2' => 1.76,
        ];
        $this->assertEquals(0, $this->vector->diff($x, $x));
        $this->assertEquals(0.01, $this->vector->diff($x, $y));
    }

    public function testCardMethod()
    {
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

        $this->assertEquals(2, $this->vector->card($x, $y));
    }

    public function testRmseMethod()
    {
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
        $this->assertEquals(0, $this->vector->rmse($x, $y));
        $this->assertEquals(0, $this->vector->rmse($x, $x));
        $x = [
            'item1' => 5,
        ];
        $y = [
            'item1' => 2.1,
        ];
        $this->assertEquals(2.9, $this->vector->rmse($x, $y));
    }
}
