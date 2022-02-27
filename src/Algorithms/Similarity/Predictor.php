<?php

namespace OpenCF\Algorithms\Similarity;

use OpenCF\Algorithms\Predictor as AbstractPredictor;

class Predictor extends AbstractPredictor
{
    public function getPrediction(array $evaluation, string $target): float
    {
        // intersect rated elements by the user
        // with sim vector of the target element
        $vectors = $this->vector->intersect(
            $evaluation,
            $this->model[$target]
        );
        // calculate the dotProduct between user
        // ratings and similarity vector
        $numerator = $this->vector->dotProduct($vectors[0], $vectors[1]);
        // calculate the sum of all the similarities
        $denominator = $this->vector->sum($vectors[1]);

        return round(($numerator / $denominator), $this->vector->getScale());
    }
}
