<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{

    public function index(){
        return view('products.index');
    }

    public function products()
    {
        $products = Product::all();
        return response()->json([
            'product' => $products,
        ]);
    }


    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [

            'name' => 'required|unique:products',
            'image' => 'required|mimes:jpeg,png,jpg|max:2048',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '400',
                'errors' => $validator->messages(),
            ]);
        } else {
            $product = new Product();
            $product->name = $request->name;
            $product->price = $request->price;
            $image = $request->file('image');
            if ($image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('/uploads/product/'), $imageName);
                $product->image = '/uploads/product/' . $imageName;
            }
            $product->status = '1';
            $product->save();
            return response()->json([
                'status' => '200',
                'message' => 'new product upload successfully',
            ]);
        }
    }


    public function edit($id)
    {

        $product = Product::findOrFail($id);
        if ($product) {
            return response()->json([
                'status' => '200',
                'product' => $product,
            ]);
        }else{
            return response()->json([
                'status' => '404',
                'message' => 'Product not found',
            ]);
        }


    }



    public function update(Request $request,$id)
    {


        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'price' => 'required',
            'image' => 'mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '400',
                'errors' => $validator->messages(),
            ]);
        } else {
            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->price = $request->price;
            $image = $request->file('image');
            if ($image) {
                @unlink($product->image);
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('/uploads/product/'), $imageName);
                $product->image = '/uploads/product/' . $imageName;
            }
            $product->save();
            return response()->json([
                'status' => '200',
                'message' => 'Product Edit successfully',
            ]);
        }
    }





    public function delete($id)
    {

        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json([
            'status' => '200',
            'success' => $product,
        ]);

    }

}
