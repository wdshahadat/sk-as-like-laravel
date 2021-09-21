<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth;
use App\Http\Models\Model;
use App\Http\Models\Product;
use App\Config\Content;
use App\Config\Request;

class RouterController extends Controller
{

    public function index(Request $request, $category, $id)
    {
        Content::$JsFiles = 'shopping_cart';
        $products = Product::all()->data();
        $categories = Model::table('product_category')->get()->data();
        return view('layouts.shop.shopping_cart', compact('products', 'categories'));
    }

    public function categories()
    {
        $productData = $this->shop_m::table('product_product')->all();
        echo Content::jsonRequest($productData);
    }

    public function create()
    {
        return view('layouts.shop.product_create');
    }

    public function update($data)
    {
        $this->shop_m::table('product_product')->update($data, ['id' => $data['id']]);
        $categories = $this->shop_m::table('product_product')->all();
        echo Content::jsonRequest($categories);
    }

    public function store()
    {
        if (isset($_POST['edit'])) {
            unset($_POST['edit']);
            return $this->update($_POST);
        }
        $this->shop_m::table('product_product')->store($_POST);
        $categories = $this->shop_m::table('product_product')->all();
        echo Content::jsonRequest($categories);
    }

    public function delete($id)
    {
        $this->shop_m::table('product_product')->delete($id);
        $data = $this->shop_m::table('product_product')->all();
        echo Content::jsonRequest($data);
    }
}
