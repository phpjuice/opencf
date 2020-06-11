<?php

namespace OpenCF\OpenCF\Contracts;

interface ISimilarity
{
    public function getSimilarity(array $xVector, array $yVector);
}
