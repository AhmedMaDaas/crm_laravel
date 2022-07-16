<?php

namespace App\Domain\Product\Actions;

use App\Domain\Product\DTO\ProductDTO;
use App\Domain\Product\Model\Product;

class DeleteProductAction
{
	public static function execute(ProductDTO $productDTO){
		$product = Product::find($productDTO->id);
		$product->delete();
		return "Deleted Successfully!";
	}
}