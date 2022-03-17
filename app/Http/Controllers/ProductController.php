<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    
    public function index()
    {
        $product = Product::all() ;
        return $product ;
    }

    
    public function store(StoreProductRequest $request)
    {      

        $product = Product::create($request->only('name', 'price'));
        return $product ;

    }

    
    public function show($id)
    {
        $product = Product::find($id); 
        return $product ;
    }

   
    public function update(UpdateProductRequest $request, $id)
    {
        
        $product = Product::find($id); 
        $product->update($request->only('name', 'price')) ;
        return $product ;
    }

    
    public function destroy($id)
    {   
        $product = Product::find($id); 
        $product->delete();
        return $product ;
    }
}
