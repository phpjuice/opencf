<?php

namespace OpenCF\Algorithms\Slopeone;

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
     * calculate the deviation between 2 items.
     *
     * @param  array  $xVector
     * @param  array  $yVector
     * @return float
     */
    public function getSimilarity(array $xVector, array $yVector): float
    {
        // get the cardinal intersecting the 2 vectors
        $card = $this->vector->card(
            $xVector,
            $yVector
        );

        // handle Exceptions
        if (0 == $card) {
            throw new InvalidArgumentException('Empty Vectors are not accepted as parameters');
        }

        // get the diff value between the 2 vectors
        $diff = $this->vector->diff(
            $xVector,
            $yVector
        );

        return round(($diff / $card), $this->vector->getScale());
    }
}
