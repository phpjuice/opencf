<?php

namespace OpenCF\Contracts;

interface IVector
{
    /**
     * cross product between 2 vectors.
     *
     * @param  array  $xVector  vector v=(1,2,3)
     * @param  array  $yVector  vector v=(1,2,3)
     *
     * @return float cross product
     */
    public function dotProduct(array $xVector, array $yVector): float;

    /**
     * check if 2 vectors are not compatible.
     *
     * @param  array  $xVector  vector v=(1,2,3)
     * @param  array  $yVector  vector v=(1,2,3)
     *
     * @return bool
     */
    public function isSparse(array $xVector, array $yVector): bool;

    /**
     * computes the intersection of 2 vectors
     * using keys for comparison.
     *
     * @param  array  $xVector  vector v=(1,2,3)
     * @param  array  $yVector  vector v=(1,2,3)
     *
     * @return array
     */
    public function intersect(array $xVector, array $yVector): array;

    /**
     * Sum of difference between two vectors Σ(v-u);.
     *
     * @param  array  $xVector  vector1
     * @param  array  $yVector  vector2
     *
     * @return float diff
     */
    public function diff(array $xVector, array $yVector): float;

    /**
     * returns the cardinal intersecting 2 vectors card(vu);.
     *
     * @param  array  $xVector  vector1
     * @param  array  $yVector  vector2
     *
     * @return int
     */
    public function card(array $xVector, array $yVector): int;

    /**
     * Root Mean Square Error (RMSE).
     *
     * @param  array  $xVector  vector v=(1,2,3)
     * @param  array  $yVector  vector v=(1,2,3)
     *
     * @return float
     */
    public function rmse(array $xVector, array $yVector): float;

    /**
     * Vector Norm, a general vector norm |x|
     * or sometimes the magnitude of a vector.
     *
     * @param  array  $vector  vector v=(1,2,3)
     *
     * @return float
     */
    public function norm(array $vector): float;

    /**
     * find the sum of all values in vector.
     *
     * @param  array  $vector  vector v=(1,2,3)
     *
     * @return float
     */
    public function sum(array $vector): float;

    /**
     * find the average of values in a vector.
     *
     * @param  array  $vector  vector v=(1,2,3)
     *
     * @return float
     */
    public function average(array $vector): float;

    /**
     * getter for the scale value.
     *
     * @return int $scale
     */
    public function getScale(): int;

    /**
     * setter for the scale value.
     *
     * @param  int  $scale
     *
     * @return self
     */
    public function setScale(int $scale): self;

    /**
     * getter for the meanVector.
     *
     * @return array $meanVector
     */
    public function getMeanVector(): array;

    /**
     * setter for the meanVector.
     *
     * @param  array  $meanVector
     * @return self
     */
    public function setMeanVector(array $meanVector): self;
}
