<?php

namespace OpenCF\Algorithms\Similarity;

use OpenCF\Algorithms\Recommender;

class Cosine extends Recommender
{
    /** @inheritdoc */
    public function name(): string
    {
        return 'Cosine';
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
