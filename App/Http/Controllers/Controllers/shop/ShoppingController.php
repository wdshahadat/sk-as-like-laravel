<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth;
use App\Http\Models\Product;
use App\Http\Models\Model;
use App\Config\Request;
use App\Config\Content;

class ShoppingController extends Controller
{
    public static $shop;

    public function __construct()
    {
        Auth::routes()->loginCheck();
    }

    public function products()
    {
        return response(Product::all()->data());
    }

    public function shopping()
    {
        Content::$JsFiles = 'shopping_cart';
        $products = Product::all()->data();
        $categories = Model::table('product_category')->get()->data();
        return view('layouts.shop.shopping_cart', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $product['name'] = $request->name;
        $product['shop_id'] = $request->shop_id;
        $product['category_id'] = $request->category_id;
        $product['price'] = $request->price;
        $product['image'] = $this->fileManage(['image' => 'uploads/products']);
        $result = Product::create($product);
        return response($result);
    }

    public function update(Request $request)
    {
        $product['name'] = $request->name;
        $product['shop_id'] = $request->shop_id;
        $product['category_id'] = $request->category_id;
        $product['price'] = $request->price;
        if (isset($request->oldImage)) {
            $product['image'] = $this->fileManage(['image' => 'uploads/products'], $request->oldImage);
        }
        return response(Product::where(['id' => getPath()])->update($product));
    }

    public function destroy($rq)
    {
        $data = Product::find($rq->id)->data();
        $delete = Product::where(['id' => $rq->id])->delete();
        if ($delete) {
            return fileDelete($data->image);
        }
        return false;
    }
}
