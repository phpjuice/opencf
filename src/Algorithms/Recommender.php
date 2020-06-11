<?php

namespace OpenCF\Algorithms;

use OpenCF\Contracts\IRecommender;
use OpenCF\Support\Vector;

abstract class Recommender implements IRecommender
{
    /**
     * training set.
     *
     * @var array[][]
     */
    protected $dataset;

    /**
     * model.
     *
     * @var array[][]
     */
    protected $model;

    /**
     * a measure function to calculate similarity.
     *
     * @var similarityFunction
     */
    protected $similarityFunction;

    /**
     * Predictor.
     *
     * @var \OpenCF\Contracts\IPredictor
     */
    protected $predictor;

    /**
     * vector calculations provider.
     *
     * @var Vector
     */
    protected $vector;

    /**
     * @param array $dataset training set
     * @param array $model   optional: previous model
     */
    public function __construct(
        $dataset,
        $model = null
    ) {
        $this->dataset = $dataset;
        $this->model = $model;
        $this->vector = new Vector();
    }

    /**
     * {@inheritdoc}
     */
    public function buildModel()
    {
        foreach ($this->dataset as $k1 => $r1) {
            foreach ($this->dataset as $k2 => $r2) {
                // if we are comparing the item
                // to it's slef we skip it
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
                } catch (\InvalidArgumentException $e) {
                    continue;
                }
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function predict(array $evaluation)
    {
        $predictions = [];
        foreach ($this->model as $key => $items) {
            // if the rating is present in the
            // evaluation given by the user we skip
            if (isset($evaluation[$key])) {
                continue;
            }
            try {
                $predictions[$key] = $this->predictor
                            ->getPrediction($evaluation, $key);
            } catch (\Exception $e) {
                continue;
            }
        }

        return $predictions;
    }

    /**
     * {@inheritdoc}
     */
    public function getModel()
    {
        return $this->model;
    }
}
