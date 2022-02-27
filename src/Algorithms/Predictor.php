<?php

namespace OpenCF\Algorithms;

use OpenCF\Contracts\IPredictor;
use OpenCF\Contracts\IVector;

abstract class Predictor implements IPredictor
{
    protected array $model;

    protected IVector $vector;

    protected array $dataset;

    /**
     * @param  array  $dataset  training set
     * @param  array  $model  optional: previous model
     * @param  IVector  $vector
     */
    public function __construct(array $dataset, array $model, IVector $vector)
    {
        $this->model = $model;
        $this->dataset = $dataset;
        $this->vector = $vector;
    }
}
