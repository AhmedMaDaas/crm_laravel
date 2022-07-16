<?php

namespace App\Http\ViewModels\Product;

use App\Domain\Product\Model\Product;
use Illuminate\Contracts\Support\Arrayable;

class ShowProductsIndexVM implements Arrayable
{
	private $products;

	public function __construct($paginate = true, $perPage = 10){
		$query = Product::orderBy('id','DESC')->with('user');
		$this->products = $paginate ? $query->paginate($perPage) : $query->get();
	}

	public function toArray()
    {
        return [
          'products' =>  $this->products
        ];
    }
}