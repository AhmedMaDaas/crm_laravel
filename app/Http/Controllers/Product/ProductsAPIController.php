<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Helper;

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

use App\Domain\Product\DTO\ProductDTO;
use App\Domain\Product\Model\Product;

class ProductsAPIController extends Controller
{
    public function index(){
        if(Auth::user()->isAdmin()){
            $productsData = new ShowProductsIndexVM();
        }
        else $productsData = new ShowUserProductsVM(Auth::id());

        $products = $productsData->toArray();
        $response = Helper::createSuccessResponse($products);
        return response()->json($response);
    }

    public function userProducts(ShowOneUserRequest $showOneUserRequest)
    {
        $userId = $showOneUserRequest->id;
        $productsData = new ShowUserProductsVM($userId, false);
        $products = $productsData->toArray();
        $response = Helper::createSuccessResponse($products);
        return response()->json($response);
    }

    public function show(ShowOneProductRequest $showOneProductRequest)
    {
        $id = $showOneProductRequest->id;
        $productData = new ShowOneProductVM($id);
        $product = $productData->toArray();
        $response = Helper::createSuccessResponse($product);
        return response()->json($response);
    }

    public function create(CreateProductRequest $createProductRequest)
    {
        $productDTO = ProductDTO::fromRequest($createProductRequest->all());
        $product = CreateProductAction::execute($productDTO);

        $response = Helper::createSuccessResponse($product);
        return response()->json($response);

    }

    public function update(UpdateProductRequest $updateProductRequest)
    {
        $productDTO = ProductDTO::fromRequest($updateProductRequest->all());
        $product = UpdateProductAction::execute($productDTO);

        $response = Helper::createSuccessResponse($product);
        return response()->json($response);

    }

    public function destroy(DeleteProductRequest $deleteProductRequest)
    {
        $productDTO = ProductDTO::fromRequest($deleteProductRequest->all());
        $message = DeleteProductAction::execute($productDTO);

        $response = Helper::createSuccessResponse($message);
        return response()->json($response);
    }
}
