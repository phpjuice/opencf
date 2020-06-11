<?php

namespace OpenCF\OpenCF\Algorithms\Similarity;

class WeightedCosine extends Cosine
{
    /**
     * {@inheritdoc}
     */
    public function name()
    {
        return 'WeightedCosine';
    }

    public function buildModel()
    {
        // Calculate the average for each evaluation
        $meanVector = $this->computeMeanVector();
        $this->vector->setMeanVector($meanVector);
        // pass the mean vector to the similarity function
        parent::buildModel();
    }

    private function computeMeanVector()
    {
        $transposed = $this->transpose();
        $meanVector = [];
        foreach ($transposed as $rating => $items) {
            $meanVector[$rating] = $this->vector->average($items);
        }//endforeach
        return $meanVector;
    }

    private function transpose()
    {
        $out = [];
        foreach ($this->dataset as $item => $ratings) {
            foreach ($ratings as $key => $value) {
                $out[$key][$item] = $value;
            }
        }

        return $out;
    }
}
