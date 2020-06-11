<?php

namespace OpenCF\OpenCF\Contracts;

interface IRecommenderService
{
    /**
     * Returns a registered recommender instance.
     *
     * @param string $name
     *
     * @throws NotRegisteredRecommenderException
     *
     * @return OpenCF\OpenCF\Contracts\IRecommender
     */
    public function getRecommender($name);

    /**
     * Registers a Recommender instance for later use.
     *
     * @param string $name recommender used to build the model
     *
     * @return $this
     */
    public function registerRecommender($name);
}
