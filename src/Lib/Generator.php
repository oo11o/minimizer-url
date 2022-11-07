<?php

namespace App\Lib;

use Symfony\Component\String\ByteString;

class Generator
{
    public function generateString($length = 4){
        return ByteString::fromRandom($length)->toString();
    }
}