<?php

namespace OpenCF\OpenCF\Algorithms\Slopeone;

use OpenCF\OpenCF\Algorithms\Recommender;

class WeightedSlopeone extends Recommender
{
    /**
     * {@inheritdoc}
     */
    public function name()
    {
        return 'WeightedSlopeone';
    }

    /**
     * {@inheritdoc}
     */
    public function buildModel()
    {
        $this->similarityFunction = new Similarity($this->vector);
        parent::buildModel();
        // after building the model
        // we pass it to the predictor
        $this->predictor = new Predictor(
            $this->dataset,
            $this->model,
            $this->vector
        );
    }
}
