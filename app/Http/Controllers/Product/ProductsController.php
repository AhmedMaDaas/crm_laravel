<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Domain\Product\Actions\UpdateProductAction;
use App\Domain\Product\Actions\CreateProductAction;
use App\Domain\Product\Actions\DeleteProductAction;

use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\DeleteProductRequest;
use App\Http\Requests\Product\ShowOneProductRequest;
use App\Http\Requests\General\User\ShowOneUserRequest;

use App\Http\ViewModels\Product\ShowOneProductVM;
use App\Http\ViewModels\Product\ShowUserProductsVM;
use App\Http\ViewModels\Product\ShowProductsIndexVM;
use App\Http\ViewModels\General\User\ShowUsersIndexVM;

use App\Domain\Product\DTO\ProductDTO;
use App\Domain\Product\Model\Product;

class ProductsController extends Controller
{
    public function index()
    {
        if(Auth::user()->isAdmin()){
            $products = new ShowProductsIndexVM();
        }
        else $products = new ShowUserProductsVM(Auth::id());

        $data = $products->toArray();
        return view('frontend.product.index', $data);
    }

    public function userProducts(ShowOneUserRequest $showOneUserRequest)
    {
        $userId = $showOneUserRequest->id;
        $productsData = new ShowUserProductsVM($userId);
        $data = $productsData->toArray();
        return view('frontend.product.index', $data);
    }

    public function create()
    {
        $users = new ShowUsersIndexVM(false);
        $data = $users->toArray();
        return view('frontend.product.create', $data);
    }

    public function store(CreateProductRequest $createProductRequest)
    {
        $productDTO = ProductDTO::fromRequest($createProductRequest->all());
        $product = CreateProductAction::execute($productDTO);

        if($product){
            request()->session()->flash('success','Successfully added Product');
        }
        else{
            request()->session()->flash('error','Error occurred while adding Product');
        }
        return redirect()->route('product.index');

    }

    public function edit(ShowOneProductRequest $showOneProductRequest)
    {
        $id = $showOneProductRequest->id;
        $product = new ShowOneProductVM($id);
        $users = new ShowUsersIndexVM(false);
        $data = array_merge($product->toArray(), $users->toArray());
        return view('frontend.product.edit', $data);
    }

    public function update(UpdateProductRequest $updateProductRequest)
    {
        $productDTO = ProductDTO::fromRequest($updateProductRequest->all());
        $product = UpdateProductAction::execute($productDTO);

        if($product){
            request()->session()->flash('success','Successfully updated');
        }
        else{
            request()->session()->flash('error','Error occured while updating');
        }
        return redirect()->route('product.index');

    }

    public function destroy(DeleteProductRequest $deleteProductRequest)
    {
        $productDTO = ProductDTO::fromRequest($deleteProductRequest->all());
        $message = DeleteProductAction::execute($productDTO);

        if($message){
            request()->session()->flash('success','Product Successfully deleted');
        }
        else{
            request()->session()->flash('error','There is an error while deleting Products');
        }
        return redirect()->route('product.index');
    }
}
