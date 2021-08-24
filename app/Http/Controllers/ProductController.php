<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        return view('modules.product.index');
    }

    public function create(Request $request){
        $categories = Category::onlyParents()->isActive()->latest()
        ->with(['children' => function($query){
            return $query->isActive();
        }])->get();

        $brands = Brand::isActive()->latest()->pluck('brand_name', 'brand_id');

        return view('modules.product.create_update', compact('categories', 'brands'));
    }
}
