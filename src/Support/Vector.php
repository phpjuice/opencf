<?php

namespace OpenCF\Support;

use OpenCF\Contracts\IVector;

class Vector implements IVector
{
    private $meanVector;
    private $scale;

    public function __construct($scale = null, array $meanVector = null)
    {
        $this->scale = ($scale) ?: 2;
        $this->meanVector = ($meanVector) ?: [];
    }

    /**
     * {@inheritdoc}
     */
    public function isSparse(array $xVector, array $yVector)
    {
        // check if the 2 vectors has compatible dimensions
        return  count($xVector) !== count($yVector);
    }

    /**
     * {@inheritdoc}
     */
    public function dotProduct(array $xVector, array $yVector)
    {
        // handle Incompatible vectors
        $vectors = $this->intersect($xVector, $yVector);
        $xVector = $vectors[0];
        $yVector = $vectors[1];

        // throw if given vector is a point
        if (1 == count($xVector)) {
            throw new \InvalidArgumentException('Vectors must have at least 2 points');
        }

        // initialise the sum variable
        $sum = 0.0;
        foreach ($xVector as $k => $v) {
            // getting the mean value from the mean vector if available
            // else we set the mean value to 0
            $mean = isset($this->meanVector[$k]) ? $this->meanVector[$k] : 0;
            // rounding the mean with the scale
            $mean = round($mean, $this->getScale());
            $x = $xVector[$k] - $mean;
            $y = $yVector[$k] - $mean;

            $sum += (float) ($x * $y);
        }

        return round($sum, $this->getScale());
    }

    /**
     * {@inheritdoc}
     */
    public function intersect(array $xVector, array $yVector)
    {
        $xVector = array_intersect_key($xVector, $yVector);
        $yVector = array_intersect_key($yVector, $xVector);

        return [$xVector, $yVector];
    }

    /**
     * {@inheritdoc}
     */
    public function diff(array $xVector, array $yVector)
    {
        // handle Incompatible vectors
        if ($this->isSparse($xVector, $yVector)) {
            throw new \InvalidArgumentException('Incompatible dimensions for xVector, yVector');
        }
        // initialise the sum variable
        $sum = 0.0;
        foreach ($xVector as $k => $v) {
            $sum += (float) ($xVector[$k] - $yVector[$k]);
        }

        return round($sum, $this->getScale());
    }

    /**
     * {@inheritdoc}
     */
    public function card(array $xVector, array $yVector)
    {
        return count(array_intersect_key($xVector, $yVector));
    }

    /**
     * {@inheritdoc}
     */
    public function rmse(array $xVector, array $yVector)
    {
        // Intersects Incompatible vectors
        $vectors = $this->intersect($xVector, $yVector);
        $xVector = $vectors[0];
        $yVector = $vectors[1];
        // get the cardinal of the 2
        $card = count($xVector);
        if (0 == $card) {
            return 0;
        }

        // initialise the rmse value
        $sum = 0.0;
        foreach ($xVector as $k => $v) {
            $sum += pow($xVector[$k] - $yVector[$k], 2);
        }

        return round(sqrt($sum / $card), $this->getScale());
    }

    /**
     * {@inheritdoc}
     */
    public function norm(array $vector)
    {
        $sum = 0.0;
        foreach ($vector as $k => $v) {
            // getting the mean value from the mean vector
            $mean = isset($this->meanVector[$k]) ? $this->meanVector[$k] : 0;
            /**
             * @see https://stackoverflow.com/questions/17210787/php-float-calculation-error-when-subtracting
             */
            $mean = round($mean, $this->getScale());
            $x = $vector[$k] - $mean;

            $sum += (float) ($x * $x);
        }

        return round(sqrt($sum), $this->getScale());
    }

    /**
     * {@inheritdoc}
     */
    public function sum(array $vector)
    {
        return round(array_sum($vector), $this->getScale());
    }

    /**
     * {@inheritdoc}
     */
    public function average(array $vector)
    {
        $vector = array_filter($vector);
        if (0 == count($vector)) {
            return 0;
        }
        $avg = $this->sum($vector) / count($vector);

        return round($avg, $this->getScale());
    }

    public function setScale($scale)
    {
        if (!is_int($scale)) {
            throw new \InvalidArgumentException('Scale must be an integer');
        }
        $this->scale = $scale;

        return $this;
    }

    public function getScale()
    {
        return $this->scale;
    }

    public function setMeanVector(array $meanVector)
    {
        $this->meanVector = $meanVector;

        return $this;
    }

    public function getMeanVector()
    {
        return $this->meanVector;
    }
}
