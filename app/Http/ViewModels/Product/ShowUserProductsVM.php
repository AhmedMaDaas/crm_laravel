<?php

namespace App\Http\ViewModels\Product;

use App\Domain\Product\Model\Product;
use Illuminate\Contracts\Support\Arrayable;

class ShowUserProductsVM implements Arrayable
{
	private $products;

	public function __construct($userId, $paginate = true, $perPage = 10){
        $query = Product::where('user_id', $userId);
        $this->products = $paginate ? $query->paginate($perPage) : $query->get();
	}

	public function toArray()
    {
        return [
          'products' =>  $this->products
        ];
    }

    public function toItem()
    {
        return $this->products;
    }
}