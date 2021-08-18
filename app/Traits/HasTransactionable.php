<?php
/*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/

namespace App\Traits;

use App\Models\Attachment;
use App\Models\Payment;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait HasTransactionable
{
    /**
     * Morph Many relation with Attachment.
     *
     * @return mixed
     */
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    protected static function bootHasTransactionable()
    {
        self::deleting(function ($model) {
            $model->transactions()->delete();
        });
    }

    public function paidAmount()
    {
        if(!empty($this->transactions)){
            return $this->transactions()->sum('amount');
        }
        return '0';
    }

    public function total()
    {
        return $this->attributes[self::total_column];
    }

    public function storeNewTransaction(Request $request)
    {
        try {
            $transaction = $this->transactions()->create([
                'amount'=>$request->paid_amount,
                'transaction_date'=> !empty($request->paid_on)? Carbon::parse($request->paid_on)->format('Y-m-d'): Carbon::today(),
                'method'=>$request->payment_method,
                'account_id'=> !empty($request->account_id)? $request->account_id: null,
                'method_details'=> !empty($request->payment_details)? json_encode($request->payment_details, true): null,
                'transaction_note'=> !empty($request->payment_note)? $request->payment_note : null,
                'transaction_type'=> Transaction::Types[self::TransType],
                'transaction_for'=> Transaction::Models[self::TransModel],
                'status'=> config('constant.active'),
            ]);
            if (!empty($transaction)){
                return $transaction->transaction_id;
            }
        }catch (\Exception $ex){
            return false;
        }
    }


}
