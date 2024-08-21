<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;

class ProductController extends Controller
{
    public function getProducts()
    {
        $products = Product::all();

        return view('list', compact('products'));
    }

    public function upload(Request $request)
    {
        $product_image=$request->file('product_image')->store('storage/images');

        $product_data = new Product();
        $product_data->name=$_POST["product_name"];
        $product_data->price=$_POST["product_price"];
        $product_data->image= $product_image;
        $product_data->description=$_POST["product_description"];
        $product_data->save();
        
        $products = Product::all();

        return view('list', compact('products'));
    }

    public function getDetail($product_id)
    {
        $product = Product::find($product_id);
        $seasons = Season::all();

        return view('detail', compact('product','seasons'));
    }

}
