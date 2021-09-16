<?php

namespace src;

require './../vendor/autoload.php';

use Illuminate\Support\Collection;

class Product
{
    public function getTotalPriceForLampAndWalletProducts()
    {
        $products = file_get_contents('./data/products.json');

        $products = json_decode($products);

        $products = collect($products)->flatten();

        return $products->filter(function ($product) {
            return collect(['Lamp', 'Wallet'])->contains($product->product_type);
        })->map(function($product){
            return collect($product->variants)->sum('price');
        })->sum();
    }
}

$product = new Product();
var_dump($product->getTotalPriceForLampAndWalletProducts());