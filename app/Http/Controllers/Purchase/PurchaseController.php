<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\BusinessLocation;
use App\Models\Transaction;
use App\Models\Contact;
use App\Models\Product;
use App\Models\PurchaseItem;
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
        $suppliers = Contact::OnlySuppler()->get();
        $businessLocations = BusinessLocation::all();
        $products = Product::all();
        $paymentMethods = array_flip(Transaction::Methods);
        return view('modules.purchase.new_purchase', compact('suppliers','businessLocations','products','paymentMethods'));
    }
}
