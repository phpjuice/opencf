<?php

namespace OpenCF\OpenCF\Contracts;

interface IVector
{
    /**
     * cross product between 2 vectors.
     *
     * @param array $xVector vector v=(1,2,3)
     * @param array $yVector vector v=(1,2,3)
     *
     * @return float cross product
     */
    public function dotProduct(array $xVector, array $yVector);

    /**
     * check if 2 vectors are not compatible.
     *
     * @param array $xVector vector v=(1,2,3)
     * @param array $yVector vector v=(1,2,3)
     *
     * @return bool
     */
    public function isSparse(array $xVector, array $yVector);

    /**
     * computes the intersection of 2 vectors
     * using keys for comparison.
     *
     * @param array $xVector vector v=(1,2,3)
     * @param array $yVector vector v=(1,2,3)
     *
     * @return array
     */
    public function intersect(array $xVector, array $yVector);

    /**
     * Sum of difference between two vectors Σ(v-u);.
     *
     * @param array $xVector vector1
     * @param array $yVector vector2
     *
     * @return float diff
     */
    public function diff(array $xVector, array $yVector);

    /**
     * returns the cardinal intersecting 2 vectors card(vu);.
     *
     * @param array $xVector vector1
     * @param array $yVector vector2
     *
     * @return float card
     */
    public function card(array $xVector, array $yVector);

    /**
     * Root Mean Square Error (RMSE).
     *
     * @param array $xVector vector v=(1,2,3)
     * @param array $yVector vector v=(1,2,3)
     *
     * @return float rmse value
     */
    public function rmse(array $xVector, array $yVector);

    /**
     * Vector Norm, a general vector norm |x|
     * or sometimes the magnitude of a vector.
     *
     * @param array $vector vector v=(1,2,3)
     *
     * @return float norm being returned
     */
    public function norm(array $vector);

    /**
     * find the sum of all values in vector.
     *
     * @param array $vector vector v=(1,2,3)
     *
     * @return float sum value
     */
    public function sum(array $vector);

    /**
     * find the average of values in a vector.
     *
     * @param array $vector vector v=(1,2,3)
     *
     * @return float average value
     */
    public function average(array $vector);

    /**
     * getter for the scale value.
     *
     * @return int $scale
     */
    public function getScale();

    /**
     * setter for the scale value.
     *
     * @param int $scale
     *
     * @return int $scale
     */
    public function setScale($scale);

    /**
     * getter for the meanVector.
     *
     * @return array $meanVector
     */
    public function getMeanVector();

    /**
     * setter for the meanVector.
     *
     * @return array $meanVector
     */
    public function setMeanVector(array $meanVector);
}
