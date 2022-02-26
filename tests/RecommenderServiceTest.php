<?php

namespace OpenCF\Tests;

use OpenCF\Algorithms\Similarity\Cosine;
use OpenCF\Algorithms\Similarity\WeightedCosine;
use OpenCF\Algorithms\Slopeone\WeightedSlopeone;
use OpenCF\Exceptions\EmptyDatasetException;
use OpenCF\Exceptions\NotRegisteredRecommenderException;
use OpenCF\RecommenderService;
use PHPUnit\Framework\TestCase as TestCase;

class RecommenderServiceTest extends TestCase
{
    public function testConstructorWithEmptyDataset()
    {
        $this->expectException(EmptyDatasetException::class);
        $recommenderService = new RecommenderService([]);
    }

    public function testRegisterNotSupportedRecommender()
    {
        $this->expectException(NotRegisteredRecommenderException::class);
        $dataset = [
            'item1' => ['rating1' => 4],
        ];
        $recommenderService = new RecommenderService($dataset);
        $recommenderService->getRecommender('Cosine');
    }

    public function testRegisterSupportedRecommender()
    {
        $dataset = [
            'item1' => ['rating1' => 4],
        ];
        $recommenderService = new RecommenderService($dataset);

        // instance of cosine
        $instance = $recommenderService->registerRecommender('Cosine');
        $this->assertInstanceOf(Cosine::class, $instance);

        // instance of weighted cosine
        $instance = $recommenderService->registerRecommender('WeightedCosine');
        $this->assertInstanceOf(WeightedCosine::class, $instance);

        // instance of weighted cosine
        $instance = $recommenderService->registerRecommender('WeightedSlopeone');
        $this->assertInstanceOf(WeightedSlopeone::class, $instance);
    }

    public function testGetRecommender()
    {
        $this->expectException(NotRegisteredRecommenderException::class);
        $dataset = [
            'item1' => ['rating1' => 4],
        ];
        $recommenderService = new RecommenderService($dataset);
        $recommenderService->getRecommender('Cosine');
    }

    public function testGetRegisteredRecommender()
    {
        $dataset = [
            'item1' => ['rating1' => 4],
        ];
        $recommenderService = new RecommenderService($dataset);
        $recommenderService->registerRecommender('Cosine');
        $instance = $recommenderService->getRecommender('Cosine');
        $this->assertInstanceOf(Cosine::class, $instance);
    }
}
