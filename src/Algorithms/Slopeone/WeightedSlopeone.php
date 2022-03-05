<?php

namespace OpenCF\Algorithms\Slopeone;

use OpenCF\Algorithms\Recommender;

class WeightedSlopeone extends Recommender
{
    /** @inheritdoc */
    public function name(): string
    {
        return 'WeightedSlopeone';
    }

    /** @inheritdoc */
    public function buildModel(): self
    {
        $this->similarityFunction = new Similarity($this->vector);
        parent::buildModel();
        // after building the model
        // we pass it to the predictor
        $this->predictor = new Predictor(
            $this->dataset,
            $this->model ?? [],
            $this->vector
        );

        return $this;
    }
}
