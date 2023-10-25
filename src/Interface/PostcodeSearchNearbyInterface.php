<?php

namespace App\Interface;

interface PostcodeSearchNearbyInterface
{
    public function findNearbyPostcodes(float $latitude, float $longitude, int $distance): array;
}
