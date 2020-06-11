<?php

namespace OpenCF\Algorithms\Similarity;

use OpenCF\Algorithms\Recommender;

class Cosine extends Recommender
{
    /**
     * {@inheritdoc}
     */
    public function name()
    {
        return 'Cosine';
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
