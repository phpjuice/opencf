<?php

namespace OpenCF;

use OpenCF\Algorithms\Similarity\Cosine;
use OpenCF\Algorithms\Similarity\WeightedCosine;
use OpenCF\Algorithms\Slopeone\WeightedSlopeone;
use OpenCF\Contracts\IRecommenderService;
use OpenCF\Exceptions\EmptyDatasetException;
use OpenCF\Exceptions\NotRegisteredRecommenderException;
use OpenCF\Exceptions\NotSupportedSchemeException;

class RecommenderService implements IRecommenderService
{
    /**
     * @var OpenCF\Contracts\IRecommender[]
     */
    private $engines = [];

    /**
     * list of the supported Engines.
     *
     * @var array
     */
    private $supportedEngines = [
        'Cosine',
        'WeightedCosine',
        'WeightedSlopeone',
    ];

    /**
     * training set.
     *
     * @var array[][]
     */
    private $dataset;

    /**
     * @param array $dataset training set
     */
    public function __construct(array $dataset)
    {
        $this->setDataset($dataset);
    }

    /**
     * setter for $dataset.
     *
     * @param array $dataset training set
     *
     * @throws EmptyDatasetException
     *
     * @return $this
     */
    public function setDataset(array $dataset = [])
    {
        if (empty($dataset)) {
            throw new EmptyDatasetException();
        }
        $this->dataset = $dataset;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRecommender($name)
    {
        if (!array_key_exists($name, $this->engines)) {
            throw new NotRegisteredRecommenderException(sprintf('The Recommendation engine "%s" is not registered in the Recommender Service', $name));
        }

        return $this->engines[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function registerRecommender($name)
    {
        if (!in_array($name, $this->supportedEngines)) {
            throw new NotSupportedSchemeException(sprintf('The Recommendation engine "%s" is not supported yet', $name));
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

        return $recommendationEngine;
    }
}
