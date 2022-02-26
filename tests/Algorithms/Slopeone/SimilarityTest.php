<?php

namespace OpenCF\Tests\Algorithms\Slopeone;

use OpenCF\Algorithms\Slopeone\Similarity;
use OpenCF\Support\Vector;
use PHPUnit\Framework\TestCase as TestCase;

class SimilarityTest extends TestCase
{
    public function testGetDeviationMethod()
    {
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
        $this->assertEquals(0.15, $results);

        $results = $algorithm->getSimilarity($xVector, $xVector);
        $this->assertEquals(0, $results);

        $this->expectException(\InvalidArgumentException::class);
        $algorithm->getSimilarity([], []);
    }
}
