<?php

namespace OpenCF\Contracts;

interface ISimilarity
{
    public function getSimilarity(array $xVector, array $yVector): float;
}
