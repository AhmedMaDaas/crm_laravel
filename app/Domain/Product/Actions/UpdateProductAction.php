<?php

namespace App\Domain\Product\Actions;

use App\Domain\Product\DTO\ProductDTO;
use App\Domain\Product\Model\Product;
use Helper;

class UpdateProductAction
{
	public static function execute(ProductDTO $productDTO){
		$productDTO->setDefaultValues();
		$product = Product::find($productDTO->id);
		$data = Helper::filterArray($productDTO->toArray(), ['size']);
		$product->update($data);
		return $product;
	}
}