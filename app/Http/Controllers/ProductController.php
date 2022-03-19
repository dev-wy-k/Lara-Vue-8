<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    
    public function index()
    {
        $product = Product::orderBy('id', 'desc')->get() ;
        return $product ;
    }

    
    public function store(StoreProductRequest $request)
    {      

        $product = Product::create($request->only('name', 'price'));
        return $product ;

    }

    
    public function show(Product $product)
    {
        return $product ;
    }

   
    public function update(UpdateProductRequest $request, Product $product)
    { 
        $product->update($request->only('name', 'price')) ;
        return $product ;
    }

    
    public function destroy(Product $product)
    {
        $product->delete();
        return $product ;
    }
}
