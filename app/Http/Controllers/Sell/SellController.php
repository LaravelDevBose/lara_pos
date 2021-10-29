<?php

namespace App\Http\Controllers\Sell;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessLocation;
use App\Models\Tax;
use App\Models\Contact;
use App\Models\Product;
use App\Models\SellItem;
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

    public function get_sell_entry_row(Request $request)
    {
        $product = Product::where('product_id', $request->product_id)->with('unit')->first();
        if(!empty($product)){
            $taxes = Tax::isActive()->get();
            $rowCount = $request->row_count;
            $row = view('modules.sell.sell_table_item', compact('product', 'taxes', 'rowCount'))->render();
            return response()->json([
                'status'=>200,
                'html'=>$row
            ]);
        }
        return response()->json([
            'status'=>400,
            'message'=>'Invalid Product information'
        ]);
    }
}
