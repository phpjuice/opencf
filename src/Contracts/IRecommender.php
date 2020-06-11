<?php

namespace OpenCF\Contracts;

interface IRecommender
{
    /**
     * return's the name of the scheme.
     *
     * @return string scheme name
     */
    public function name();

    /**
     * get the computed model.
     *
     * @return array model
     */
    public function getModel();

    /**
     * compute a model based on a training set.
     *
     * @return array model
     */
    public function buildModel();

    /**
     * predict future ratings based on a model.
     *
     * @param array $userRatings user evaluation
     *
     * @return array Predictions
     */
    public function predict(array $userRatings);
}
