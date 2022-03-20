<?php

namespace OpenCF\Algorithms;

use Exception;
use InvalidArgumentException;
use OpenCF\Contracts\IPredictor;
use OpenCF\Contracts\IRecommender;
use OpenCF\Contracts\ISimilarity;
use OpenCF\Contracts\IVector;
use OpenCF\Exceptions\EmptyDatasetException;
use OpenCF\Exceptions\EmptyModelException;
use OpenCF\Support\Vector;

abstract class Recommender implements IRecommender
{
    /** @var array */
    protected array $dataset;

    /** @var array|null */
    protected ?array $model;

    /**
     * @var ISimilarity
     */
    protected ISimilarity $similarityFunction;

    /**
     * @var IPredictor
     */
    protected IPredictor $predictor;

    /**
     * @var IVector
     */
    protected IVector $vector;

    /**
     * @param  array  $dataset  training set
     * @param  array|null  $model  optional: previous model
     */
    public function __construct(
        array $dataset,
        array $model = null
    ) {
        $this->dataset = $dataset;
        $this->model = $model;
        $this->vector = new Vector();
    }

    /** @inheritdoc */
    public function buildModel(): self
    {
        if (empty($this->dataset)) {
            throw new EmptyDatasetException();
        }

        foreach ($this->dataset as $k1 => $r1) {
            foreach ($this->dataset as $k2 => $r2) {
                // if we are comparing the item
                // to its self we skip it
                if ($k1 === $k2) {
                    continue;
                }

                $vectors = $this->vector->intersect(
                    $this->dataset[$k1],
                    $this->dataset[$k2]
                );

                try {
                    // save the measure to the model
                    $this->model[$k1][$k2] =
                        $this->similarityFunction
                            ->getSimilarity($vectors[0], $vectors[1]);
                } catch (InvalidArgumentException $e) {
                    continue;
                }
            }
        }

        return $this;
    }

    /** @inheritdoc */
    public function predict(array $userRatings): array
    {
        if (empty($this->model)) {
            throw new EmptyModelException();
        }

        $predictions = [];
        foreach ($this->model as $key => $items) {
            // if the rating is present in the
            // evaluation given by the user we skip
            if (isset($userRatings[$key])) {
                continue;
            }

            try {
                $predictions[$key] = $this->predictor
                    ->getPrediction($userRatings, $key);
            } catch (Exception $e) {
                continue;
            }
        }

        return $predictions;
    }

    /** @inheritdoc */
    public function getModel(): array
    {
        return $this->model ?? [];
    }
}
