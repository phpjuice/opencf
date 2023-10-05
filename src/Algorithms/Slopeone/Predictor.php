<?php

namespace OpenCF\Algorithms\Slopeone;

use OpenCF\Algorithms\Predictor as AbstractPredictor;

class Predictor extends AbstractPredictor
{
    public function getPrediction(array $evaluation, string $target): float
    {
        // intersect rated elements by the user
        // with dev vector of the target element
        $vectors = $this->vector->intersect(
            $evaluation,
            $this->model[$target]
        );

        // get the target ratings from
        // the data set
        $targetVector = $this->dataset[$target];

        $freq = 0;
        $sum = 0.0;
        foreach ($vectors[0] as $key => $value) {
            $currentVector = $this->dataset[$key];
            // we get the cardinal of the intersection
            // between each rated item with the target
            // item Cji => card(Sji(x))
            // where "J" is Fixed and "I" is the iterator
            $card = $this->vector->card($targetVector, $currentVector);

            // we get the user rating value and add it to
            // the dev[j][i] then multiply with the card
            // (dev[j][i] + U[i]) * Cji
            $sum += ($value + $vectors[1][$key]) * $card;
            $freq += $card;
        }

        $predValue = $sum / ($freq !== 0 ? $freq : 1);

        return round($predValue, $this->vector->getScale());
    }
}
