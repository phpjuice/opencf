<?php

namespace OpenCF\OpenCF\Algorithms;

use OpenCF\OpenCF\Contracts\IPredictor;
use OpenCF\OpenCF\Contracts\IVector;

abstract class Predictor implements IPredictor
{
    protected $model;
    protected $vector;
    protected $dataset;

    /**
     * @param array $dataset training set
     * @param array $model   optional: previous model
     */
    public function __construct($dataset, $model, IVector $vector)
    {
        $this->model = $model;
        $this->dataset = $dataset;
        $this->vector = $vector;
    }
}
