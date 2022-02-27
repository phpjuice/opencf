<?php

namespace OpenCF\Contracts;

interface IRecommender
{
    /**
     * return's the name of the scheme.
     *
     * @return string
     */
    public function name(): string;

    /**
     * get the computed model.
     *
     * @return array
     */
    public function getModel(): array;

    /**
     * compute a model based on a training set.
     *
     * @return self
     */
    public function buildModel(): self;

    /**
     * predict future ratings based on a model.
     *
     * @param  array  $userRatings  user evaluation
     *
     * @return array
     */
    public function predict(array $userRatings): array;
}
