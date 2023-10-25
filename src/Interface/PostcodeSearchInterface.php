<?php

namespace App\Interface;

interface PostcodeSearchInterface
{
    public function findAll();
    
    public function findByPartialString(string $postcode): array;
}
