<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() : View {
        $products = Product::paginate(10);

        return view("products.index", compact("products"));
    }

    public function create() : View {
        return view("products.create");
    }

    public function store(StoreProductRequest $request){
        Product::create($request->validated());

        return redirect(route("products.index"));
    }

    public function edit(Product $product) : View {
        return view("products.edit", compact("product"));
    }

    public function update(UpdateProductRequest $request, Product $product) {
        $product->update($request->validated());
        return redirect(route("products.index"));
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect(route("products.index"));
    }
}
