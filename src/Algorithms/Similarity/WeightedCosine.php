<?php

namespace OpenCF\Algorithms\Similarity;

class WeightedCosine extends Cosine
{
    public function name(): string
    {
        return 'WeightedCosine';
    }

    public function buildModel(): self
    {
        // Calculate the average for each evaluation
        $meanVector = $this->computeMeanVector();
        $this->vector->setMeanVector($meanVector);
        // pass the mean vector to the similarity function
        parent::buildModel();

        return $this;
    }

    private function computeMeanVector(): array
    {
        $transposed = $this->transpose();
        $meanVector = [];
        foreach ($transposed as $rating => $items) {
            $meanVector[$rating] = $this->vector->average($items);
        }//endforeach

        return $meanVector;
    }

    private function transpose(): array
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
