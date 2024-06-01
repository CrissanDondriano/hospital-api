<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return response()->json($products);
    }

    public function store(Request $request){
        $products = Product::create([
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);
        return response()->json($products, 201);
    }

    public function show($id){
        $products = Product::find($id);
        return response()->json($products, 200);
    }

    public function search($product_name){
        $products = Product::with('user')->where('product_name', 'like', '%' . $product_name . '%')->get();
        return response()->json($products, 200);        
    }

    public function update(Request $request, $id){
        $products = Product::find($id);
        $products->update([
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);
        return response()->json($products, 200);
    }

    public function destroy($id){
        $products = Product::find($id);
        $products->delete();
        return response()->json(null, 204);
    }
}
