<?php

namespace OpenCF\Algorithms\Similarity;

use InvalidArgumentException;
use OpenCF\Contracts\ISimilarity;
use OpenCF\Contracts\IVector;

class Similarity implements ISimilarity
{
    protected IVector $vector;

    /**
     * @param  IVector  $vector  service provider
     */
    public function __construct(IVector $vector)
    {
        $this->vector = $vector;
    }

    /**
     * calculate the cosine similarity between 2 vectors.
     *
     * @return float similarity value
     * @throws InvalidArgumentException
     */
    public function getSimilarity(array $xVector, array $yVector): float
    {
        // get the cardinal intersecting the 2 vectors
        $card = $this->vector->card(
            $xVector,
            $yVector
        );

        // handle Exceptions
        if ($card <= 1) {
            throw new InvalidArgumentException('Vectors must have at least 2 point');
        }

        $dotProduct = $this->vector->dotProduct(
            $xVector,
            $yVector
        );

        $denominator1 = $this->vector->norm($xVector);
        $denominator2 = $this->vector->norm($yVector);
        $denominator = $denominator1 * $denominator2;

        if ($denominator > 0) {
            $scale = $this->vector->getScale();

            return round(($dotProduct / $denominator), $scale);
        }

        return 0;
    }
}
