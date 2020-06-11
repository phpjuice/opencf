<?php

namespace OpenCF\Algorithms\Slopeone;

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
     * calculate the deviation between 2 items.
     *
     * @throws \InvalidArgumentException
     *
     * @return float deviation value
     */
    public function getSimilarity(array $xVector, array $yVector)
    {
        // get the cardinal intersecting the 2 vectors
        $card = $this->vector->card(
            $xVector,
            $yVector
        );

        // handle Exceptions
        if (0 == $card) {
            throw new \InvalidArgumentException('Empty Vectors are not accepted as parameters');
        }

        // get the diff value between the 2 vectors
        $diff = $this->vector->diff(
            $xVector,
            $yVector
        );

        return round(($diff / $card), $this->vector->getScale());
    }
}
