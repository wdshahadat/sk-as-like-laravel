<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth;
use App\Http\Models\Model;
use App\Config\Request;
use App\Config\Content;

class CategoryController extends Controller
{
    public $shop_m;

    public function __construct()
    {
        Auth::routes()->loginCheck();
    }

    public function index()
    {
        Content::$JsFiles = 'category';
        $categoryList = Model::table('product_category')->all()->data();
        return view('layouts.shop.categories', compact('categoryList'));
    }

    public function categories()
    {
        return response(Model::table('product_category')->all()->data());
    }

    public function create()
    {
        return view('layouts.shop.category_create');
    }

    public function store(Request $request)
    {
        return response(Model::table('product_category')->store(['shop_id' => 1, 'category' => $request->category]));
    }

    public function update(Request $request)
    {
        return response(Model::table('product_category')
        ->where(['id' => $request->id])->update(['category'=>$request->category]));
    }

    public function delete(Request $request)
    {
        return Model::table('product_category')->where(['id' => $request->id])->delete();
    }
}
