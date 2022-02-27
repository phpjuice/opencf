<?php

namespace OpenCF\Support;

use InvalidArgumentException;
use OpenCF\Contracts\IVector;

class Vector implements IVector
{
    private array $meanVector;

    private int $scale;

    public function __construct(int $scale = null, array $meanVector = null)
    {
        $this->scale = ($scale) ?: 2;
        $this->meanVector = ($meanVector) ?: [];
    }

    /** @inheritdoc */
    public function dotProduct(array $xVector, array $yVector): float
    {
        // handle Incompatible vectors
        $vectors = $this->intersect($xVector, $yVector);
        $xVector = $vectors[0];
        $yVector = $vectors[1];

        // throw if given vector is a point
        if (1 == count($xVector)) {
            throw new InvalidArgumentException('Vectors must have at least 2 points');
        }

        // initialise the sum variable
        $sum = 0.0;
        foreach ($xVector as $k => $v) {
            // getting the mean value from the mean vector if available
            // else we set the mean value to 0
            $mean = $this->meanVector[$k] ?? 0;
            // rounding the mean with the scale
            $mean = round($mean, $this->getScale());
            $x = $v - $mean;
            $y = $yVector[$k] - $mean;

            $sum += (float) ($x * $y);
        }

        return round($sum, $this->getScale());
    }

    /** @inheritdoc */
    public function intersect(array $xVector, array $yVector): array
    {
        $xVector = array_intersect_key($xVector, $yVector);
        $yVector = array_intersect_key($yVector, $xVector);

        return [$xVector, $yVector];
    }

    /** @inheritdoc */
    public function getScale(): int
    {
        return $this->scale;
    }

    /** @inheritdoc */
    public function setScale(int $scale): self
    {
        $this->scale = $scale;

        return $this;
    }

    /** @inheritdoc */
    public function diff(array $xVector, array $yVector): float
    {
        // handle Incompatible vectors
        if ($this->isSparse($xVector, $yVector)) {
            throw new InvalidArgumentException('Incompatible dimensions for xVector, yVector');
        }
        // initialise the sum variable
        $sum = 0.0;
        foreach ($xVector as $k => $v) {
            $sum += (float) ($v - $yVector[$k]);
        }

        return round($sum, $this->getScale());
    }

    /** @inheritdoc */
    public function isSparse(array $xVector, array $yVector): bool
    {
        // check if the 2 vectors has compatible dimensions
        return count($xVector) !== count($yVector);
    }

    /** @inheritdoc */
    public function card(array $xVector, array $yVector): int
    {
        return count(array_intersect_key($xVector, $yVector));
    }

    /** @inheritdoc */
    public function rmse(array $xVector, array $yVector): float
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
            $sum += pow($v - $yVector[$k], 2);
        }

        return round(sqrt($sum / $card), $this->getScale());
    }

    /** @inheritdoc */
    public function norm(array $vector): float
    {
        $sum = 0.0;
        foreach ($vector as $k => $v) {
            // getting the mean value from the mean vector
            $mean = $this->meanVector[$k] ?? 0;
            /**
             * @see https://stackoverflow.com/questions/17210787/php-float-calculation-error-when-subtracting
             */
            $mean = round($mean, $this->getScale());
            $x = $v - $mean;

            $sum += (float) ($x * $x);
        }

        return round(sqrt($sum), $this->getScale());
    }

    /** @inheritdoc */
    public function average(array $vector): float
    {
        $vector = array_filter($vector);
        if (0 == count($vector)) {
            return 0;
        }
        $avg = $this->sum($vector) / count($vector);

        return round($avg, $this->getScale());
    }

    /** @inheritdoc */
    public function sum(array $vector): float
    {
        return round(array_sum($vector), $this->getScale());
    }

    public function getMeanVector(): array
    {
        return $this->meanVector;
    }

    public function setMeanVector(array $meanVector): self
    {
        $this->meanVector = $meanVector;

        return $this;
    }
}
