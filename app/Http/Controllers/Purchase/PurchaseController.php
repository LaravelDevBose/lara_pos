<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        return view('modules.purchase.purchase_list');
    }

    public function datatable(Request $request)
    {

    }

    public function create()
    {
        return view('modules.purchase.new_purchase');
    }
}
