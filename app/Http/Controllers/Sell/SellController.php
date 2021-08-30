<?php

namespace App\Http\Controllers\Sell;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellController extends Controller
{
    public function index()
    {
        return view('modules.sell.sell_list');
    }

    public function datatable(Request $request)
    {

    }

    public function create()
    {
        return view('modules.sell.new_sell');
    }
}
