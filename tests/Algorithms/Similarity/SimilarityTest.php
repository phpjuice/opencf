<?php

namespace OpenCF\OpenCF\Tests\Algorithms\Similarity;

use OpenCF\OpenCF\Algorithms\Similarity\Similarity;
use OpenCF\OpenCF\Support\Vector;
use PHPUnit\Framework\TestCase as TestCase;

class SimilarityTest extends TestCase
{
    public function testGetSimilarity()
    {
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
        $this->assertEquals(1, $results);

        $results = $algorithm->getSimilarity($xVector, $yVector);
        $this->assertEquals(0.55, $results);

        $results = $algorithm->getSimilarity($xVector, $yVector);
        $this->assertNotEquals(1, $results);
    }

    public function testGetSimilarityWithMean()
    {
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
        $this->assertEquals(-0.66, $results);
    }
}
