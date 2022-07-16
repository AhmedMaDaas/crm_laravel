<?php

namespace App\Http\ViewModels\Product;

use App\Domain\Product\Model\Product;
use Illuminate\Contracts\Support\Arrayable;

class ShowOneProductVM implements Arrayable
{
	private $product;

	public function __construct($productId){
		$this->product = Product::with(['user'])->find($productId);
	}

	public function toArray()
    {
        return [
          'product' =>  $this->product
        ];
    }

    public function toItem()
    {
        return $this->product;
    }
}