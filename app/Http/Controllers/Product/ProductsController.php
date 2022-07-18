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

class ProductsController extends Controller
{
    private $perPage = 10;
    private $path = 'products/image/';

    public function index()
    {
        if(Auth::user()->isAdmin()){
            $products = Product::orderBy('id','DESC')->with('user')->paginate($this->perPage);
        }
        else $products = Product::where('user_id', Auth::id())->with('user')->paginate($this->perPage);

        $data = ['products' => $products];
        return view('frontend.product.index', $data);
    }

    public function userProducts(ShowOneUserRequest $showOneUserRequest)
    {
        $userId = $showOneUserRequest->id;
        $products = Product::where('user_id', $userId)->paginate($this->perPage);
        $data = ['products' => $products];
        return view('frontend.product.index', $data);
    }

    public function create()
    {
        $users = User::all();
        $data = ['users' => $users];
        return view('frontend.product.create', $data);
    }

    public function store(CreateProductRequest $createProductRequest)
    {
        $data = $createProductRequest->validated();

        if(isset($data['image']) && $data['image'] instanceof UploadedFile){
            $data['image'] = $this->path . Helper::saveFileGetLinkWithName($data['image'], $this->path)['fileName'];
        }

        $product = Product::create($data);

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
        $product = Product::with(['user'])->find($id);
        $users = User::all();
        $data = [
            'users' => $users,
            'product' => $product
        ];
        return view('frontend.product.edit', $data);
    }

    public function update(UpdateProductRequest $updateProductRequest)
    {
        $data = $updateProductRequest->validated();

        if(isset($data['image']) && $data['image'] instanceof UploadedFile){
            $data['image'] = $this->path . Helper::saveFileGetLinkWithName($data['image'], $this->path)['fileName'];
        }

        $product = Product::find($data['id']);
        $result = $product->update($data);

        if($result){
            request()->session()->flash('success','Successfully updated');
        }
        else{
            request()->session()->flash('error','Error occured while updating');
        }
        return redirect()->route('product.index');

    }

    public function destroy(DeleteProductRequest $deleteProductRequest)
    {
        $product = Product::find($deleteProductRequest->id);
        $product->delete();

        request()->session()->flash('success','Product Successfully deleted');
        return redirect()->route('product.index');
    }
}
