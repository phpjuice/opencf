<?php

namespace OpenCF\Contracts;

interface IPredictor
{
    public function getPrediction(array $evaluation, $target);
}
