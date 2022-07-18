<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Helper;

use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\DeleteProductRequest;
use App\Http\Requests\Product\ShowOneProductRequest;
use App\Http\Requests\User\ShowOneUserRequest;

use App\Models\Product;
use App\Models\User;

class ProductsAPIController extends Controller
{
    private $perPage = 10;
    private $path = 'products/image/';

    public function index(){
        if(Auth::user()->isAdmin()){
            $products = Product::orderBy('id','DESC')->with('user')->paginate($this->perPage);
        }
        else $products = Product::where('user_id', Auth::id())->with('user')->paginate($this->perPage);

        $response = Helper::createSuccessResponse($products);
        return response()->json($response);
    }

    public function userProducts(ShowOneUserRequest $showOneUserRequest)
    {
        $userId = $showOneUserRequest->id;
        $products = Product::where('user_id', $userId)->paginate($this->perPage);
        $response = Helper::createSuccessResponse($products);
        return response()->json($response);
    }

    public function show(ShowOneProductRequest $showOneProductRequest)
    {
        $id = $showOneProductRequest->id;
        $product = Product::with(['user'])->find($id);
        $response = Helper::createSuccessResponse($product);
        return response()->json($response);
    }

    public function create(CreateProductRequest $createProductRequest)
    {
        $data = $createProductRequest->validated();

        if(isset($data['image']) && $data['image'] instanceof UploadedFile){
            $data['image'] = $this->path . Helper::saveFileGetLinkWithName($data['image'], $this->path)['fileName'];
        }

        $product = Product::create($data);

        $response = Helper::createSuccessResponse($product);
        return response()->json($response);

    }

    public function update(UpdateProductRequest $updateProductRequest)
    {
        $data = $updateProductRequest->validated();

        if(isset($data['image']) && $data['image'] instanceof UploadedFile){
            $data['image'] = $this->path . Helper::saveFileGetLinkWithName($data['image'], $this->path)['fileName'];
        }

        $product = Product::find($data['id']);
        $result = $product->update($data);

        $response = Helper::createSuccessResponse($product);
        return response()->json($response);

    }

    public function destroy(DeleteProductRequest $deleteProductRequest)
    {
        $product = Product::find($deleteProductRequest->id);
        $product->delete();

        $response = Helper::createSuccessResponse('Product Successfully deleted');
        return response()->json($response);
    }
}
