<?php

namespace OpenCF\Contracts;

use OpenCF\Exceptions\NotRegisteredRecommenderException;

interface IRecommenderService
{
    /**
     * Returns a registered recommender instance.
     *
     * @param  string  $recommender
     * @return IRecommender
     * @throws NotRegisteredRecommenderException
     */
    public function getRecommender(string $recommender): IRecommender;

    /**
     * Registers a Recommender instance for later use.
     *
     * @param  string  $recommender  recommender used to build the model
     *
     * @return $this
     */
    public function registerRecommender(string $recommender): self;

    /**
     * Return's a weighted slopeone recommender.
     * @return IRecommender
     */
    public function weightedSlopeone(): IRecommender;

    /**
     * Return's a weighted cosine recommender.
     * @return IRecommender
     */
    public function weightedCosine(): IRecommender;

    /**
     * Return's a cosine recommender.
     * @return IRecommender
     */
    public function cosine(): IRecommender;
}
