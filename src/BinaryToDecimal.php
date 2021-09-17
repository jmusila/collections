<?php

namespace src;

require './../vendor/autoload.php';

class BinaryToDecimal
{
    public function binaryToDecimalConverter()
    {
        $binary = '11010';

        $columns = collect(str_split($binary))->reverse()->values();

        return $columns->map(function($column, $key){
            return $column * (2**$key);
        })->sum();
    }
}

$binary = new BinaryToDecimal();

echo($binary->binaryToDecimalConverter());
