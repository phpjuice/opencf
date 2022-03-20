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
use ReflectionClass;
use ReflectionException;

class RecommenderService implements IRecommenderService
{
    /**
     * list of registered engines.
     *
     * @var array<IRecommender>
     */
    private array $recommenders = [];

    /**
     * list of the supported Engines.
     *
     * @var array<string>
     */
    private array $defaultRecommenders = [
        Cosine::class,
        WeightedCosine::class,
        WeightedSlopeone::class,
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

        // register default recommenders
        foreach ($this->defaultRecommenders as $recommender) {
            $this->recommenders[$recommender] = new $recommender($this->dataset);
        }
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

    public function weightedSlopeone(): IRecommender
    {
        if (! in_array(WeightedSlopeone::class, $this->recommenders)) {
            $this->registerRecommender(WeightedSlopeone::class);
        }

        return $this->getRecommender(WeightedSlopeone::class);
    }

    public function registerRecommender(string $recommender): self
    {
        try {
            $rf = new ReflectionClass($recommender);
        } catch (ReflectionException $e) {
            throw new NotSupportedSchemeException(sprintf(
                'Recommendation engine "%s" must implement "%s" interface',
                $recommender,
                IRecommender::class
            ));
        }

        if (! $rf->implementsInterface(IRecommender::class)) {
            throw new NotSupportedSchemeException(sprintf(
                'Recommendation engine "%s" must implement "%s" interface',
                $recommender,
                IRecommender::class
            ));
        }

        if (! in_array($recommender, $this->recommenders)) {
            $this->recommenders[$recommender] = new $recommender($this->dataset);
        }

        return $this;
    }

    public function getRecommender(string $recommender): IRecommender
    {
        if (! array_key_exists($recommender, $this->recommenders)) {
            throw new NotRegisteredRecommenderException(sprintf(
                'The Recommendation engine "%s" is not registered in the Recommender Service',
                $recommender
            ));
        }

        return $this->recommenders[$recommender]->buildModel();
    }

    public function weightedCosine(): IRecommender
    {
        if (! in_array(WeightedCosine::class, $this->recommenders)) {
            $this->registerRecommender(WeightedCosine::class);
        }

        return $this->getRecommender(WeightedCosine::class);
    }

    public function cosine(): IRecommender
    {
        if (! in_array(Cosine::class, $this->recommenders)) {
            $this->registerRecommender(Cosine::class);
        }

        return $this->getRecommender(Cosine::class);
    }
}
