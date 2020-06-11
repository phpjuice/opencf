<?php

namespace OpenCF\Algorithms\Similarity;

use OpenCF\Contracts\ISimilarity;
use OpenCF\Contracts\IVector;

class Similarity implements ISimilarity
{
    protected $vector;

    /**
     * @param IVector $vector service provier
     */
    public function __construct(IVector $vector)
    {
        $this->vector = $vector;
    }

    /**
     * calculate the cosine similarity between 2 vectors.
     *
     * @throws \InvalidArgumentException
     *
     * @return float similarity value
     */
    public function getSimilarity(array $xVector, array $yVector)
    {
        // get the cardinal intersecting the 2 vectors
        $card = $this->vector->card(
            $xVector,
            $yVector
        );

        // handle Exceptions
        if ($card <= 1) {
            throw new \InvalidArgumentException('Vectors must have at least 2 point');
        }

        $dotProduct = $this->vector->dotProduct(
            $xVector,
            $yVector
        );

        $denom1 = $this->vector->norm($xVector);
        $denom2 = $this->vector->norm($yVector);
        $denom = $denom1 * $denom2;

        if ($denom > 0) {
            $scale = $this->vector->getScale();

            return round(($dotProduct / $denom), $scale);
        }

        return 0;
    }
}
