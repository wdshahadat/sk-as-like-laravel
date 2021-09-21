<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth;
use App\Http\Models\Model;
use App\Config\Content;

class ProductController extends Controller
{
    public $shop_m;

    public function __construct()
    {
        Auth::routes()->loginCheck();
    }

    public function index()
    {
        Content::$JsFiles = 'product';
        return view('layouts.shop.categories');
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

    public function check()
    {
        $categories = $this->shop_m::table('product_product')->all();
        echo Content::jsonRequest($categories);
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
