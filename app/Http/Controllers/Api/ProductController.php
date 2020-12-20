<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $query = $request->get('query');
        $products = Product::where("title", "LIKE", "%$query%")->latest('id')->paginate($request->per_page);
        return new ProductCollection($products);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            "title" => "required|string|max:255",
            "description" => "required|string",
            "price" => "required",
            "image" => "required|image|max:2000",
        ]);

        if($request->hasFile("image")){
            $attributes["image"] = $request->image->store("products");
        }

        $product = Product::create($attributes);

        if($product) {
            return new ProductResource($product);
        }else{
            return response()->json(["error" => "Product creating failed"]);
        }
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {

        $attributes = $request->validate([
            "title" => "required|string|max:255",
            "description" => "required|string",
            "price" => "required|numeric",
            "image" => "nullable|image|max:2000",
        ]);

        if($request->hasFile("image")){
            $this->removeImage($product->image);
            $attributes["image"] = $request->image->store("products");
        }else{
            $attributes["image"] = $product->image;
        }

        $updated = $product->update($attributes);

        if($updated) {
            return new ProductResource($product);
        }else{
            return response()->json(["error" => "Product updating failed"]);
        }
    }

    public function destroy(Product $product)
    {
        $this->removeImage($product->image);
        $delete = $product->delete();

        if($delete){
            return new ProductResource($product);
        }else{
            return response()->json(["error" => "Product deleteing failed"]);
        }
    }

    public function removeImage($image)
    {
        Storage::delete($image);
    }
}
