<?php

namespace App\Http\Controllers\Sell;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $customers = Contact::OnlyCustomer()->get();
        return view('modules.sell.pos_sell_page', compact('customers','categories','brands'));
    }
}
