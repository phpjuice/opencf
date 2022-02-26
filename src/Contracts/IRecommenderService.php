<?php

namespace OpenCF\Contracts;

use OpenCF\Exceptions\NotRegisteredRecommenderException;

interface IRecommenderService
{
    /**
     * Returns a registered recommender instance.
     *
     * @param  string  $name
     *
     * @return IRecommender
     * @throws NotRegisteredRecommenderException
     */
    public function getRecommender(string $name): IRecommender;

    /**
     * Registers a Recommender instance for later use.
     *
     * @param  string  $name  recommender used to build the model
     *
     * @return $this
     */
    public function registerRecommender(string $name): self;
}
