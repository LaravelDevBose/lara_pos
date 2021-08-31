<?php

namespace App\Http\Controllers\Sell;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessLocation;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Transaction;

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
        $businessLocations = BusinessLocation::all();
        $paymentMethods = array_flip(Transaction::Methods);
        $customers = Contact::OnlyCustomer()->get();
        return view('modules.sell.new_sell',compact('businessLocations','paymentMethods','customers'));
    }
}
