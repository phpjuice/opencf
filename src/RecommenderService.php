<?php

namespace OpenCF;

use OpenCF\Algorithms\Similarity\Cosine;
use OpenCF\Algorithms\Similarity\WeightedCosine;
use OpenCF\Algorithms\Slopeone\WeightedSlopeone;
use OpenCF\Contracts\IRecommender;
use OpenCF\Contracts\IRecommenderService;
use OpenCF\Exceptions\EmptyDatasetException;
use OpenCF\Exceptions\NotRegisteredRecommenderException;
use OpenCF\Exceptions\NotSupportedSchemeException;

class RecommenderService implements IRecommenderService
{
    /**
     * @var IRecommender[]
     */
    private array $engines = [];

    /**
     * list of the supported Engines.
     *
     * @var array
     */
    private array $supportedEngines = [
        'Cosine',
        'WeightedCosine',
        'WeightedSlopeone',
    ];

    /**
     * training set.
     *
     * @var array[][]
     */
    private array $dataset;

    /**
     * @param  array  $dataset  training set
     */
    public function __construct(array $dataset)
    {
        $this->setDataset($dataset);
    }

    /**
     * setter for $dataset.
     *
     * @param  array  $dataset  training set
     *
     * @return $this
     * @throws EmptyDatasetException
     */
    public function setDataset(array $dataset = []): self
    {
        if (empty($dataset)) {
            throw new EmptyDatasetException();
        }
        $this->dataset = $dataset;

        return $this;
    }

    public function getRecommender(string $name): IRecommender
    {
        if (! array_key_exists($name, $this->engines)) {
            throw new NotRegisteredRecommenderException(sprintf('The Recommendation engine "%s" is not registered in the Recommender Service',
                $name));
        }

        return $this->engines[$name];
    }

    public function registerRecommender(string $name): self
    {
        if (! in_array($name, $this->supportedEngines)) {
            throw new NotSupportedSchemeException(sprintf('The Recommendation engine "%s" is not supported yet',
                $name));
        }
        switch ($name) {
            case 'WeightedCosine':
                $recommendationEngine = new WeightedCosine($this->dataset);
                break;
            case 'WeightedSlopeone':
                $recommendationEngine = new WeightedSlopeone($this->dataset);
                break;
            default:
                $recommendationEngine = new Cosine($this->dataset);
                break;
        }
        $this->engines[$recommendationEngine->name()] = $recommendationEngine;

        return $this;
    }
}
