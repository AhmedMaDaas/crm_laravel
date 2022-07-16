<?php

namespace App\Domain\Product\Actions;

use App\Domain\Product\DTO\ProductDTO;
use App\Domain\Product\Model\Product;

class CreateProductAction
{
	public static function execute(ProductDTO $productDTO){
		$productDTO->setDefaultValues();
		$product = Product::create($productDTO->toArray());
		return $product;
	}
}