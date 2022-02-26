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
    public function testConstructorWithEmptyDataset(): void
    {
        $this->expectException(EmptyDatasetException::class);
        new RecommenderService([]);
    }

    public function testRegisterNotSupportedRecommender(): void
    {
        $this->expectException(NotRegisteredRecommenderException::class);
        $dataset = [
            'item1' => ['rating1' => 4],
        ];
        $recommenderService = new RecommenderService($dataset);
        $recommenderService->getRecommender('Cosine');
    }

    public function testRegisterSupportedRecommender(): void
    {
        $dataset = [
            'item1' => ['rating1' => 4],
        ];
        $recommenderService = new RecommenderService($dataset);

        // instance of cosine
        $recommenderService->registerRecommender('Cosine');
        $this->assertInstanceOf(Cosine::class, $recommenderService->getRecommender('Cosine'));

        // instance of weighted cosine
        $recommenderService->registerRecommender('WeightedCosine');
        $this->assertInstanceOf(WeightedCosine::class, $recommenderService->getRecommender('WeightedCosine'));

        // instance of weighted cosine
        $recommenderService->registerRecommender('WeightedSlopeone');
        $this->assertInstanceOf(WeightedSlopeone::class, $recommenderService->getRecommender('WeightedSlopeone'));
    }

    public function testGetRecommender(): void
    {
        $this->expectException(NotRegisteredRecommenderException::class);
        $dataset = [
            'item1' => ['rating1' => 4],
        ];
        $recommenderService = new RecommenderService($dataset);
        $recommenderService->getRecommender('Cosine');
    }

    public function testGetRegisteredRecommender(): void
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
