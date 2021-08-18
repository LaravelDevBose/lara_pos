<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use HasFilter;
    use SoftDeletes;

    const Models =[
        'Expense'=>1,
        'Purchase'=>2,
        'Sell'=>3,
        'Purchase Return'=>4,
        'Sell Return'=>5
    ];

    const Methods = [
        'Cash'=>1,
        'Card'=>2,
        'Cheque'=>3,
        'Bank Transfer'=>4,
        'Other'=>5
    ];

    const PaymentStatus = [
        'Paid'=>1,
        'Due'=>2,
        'Partial'=>3
    ];
     const Types=[
         'Cr'=>1,
         'Dr'=>2
     ];

    protected $table='transactions';
    protected $primaryKey='transaction_id';

    protected $fillable=[
        'transactionable_id',
        'transactionable_type',
        'amount',
        'transaction_date',
        'method',
        'account_id',
        'method_details',
        'transaction_note',
        'transaction_type',
        'transaction_for',
        'status'
    ];

//    payment Details fields
//    'card_number',
//    'card_holder_name',
//    'card_tran_no',
//    'card_type',
//    'cheque_no',
//    'bank_account_no',


    protected $casts=['method_label'];

    public function getMethodDetailsAttribute()
    {
        return json_decode($this->attributes['method_details'], true);
    }

    public function getMethodLabelAttribute()
    {
        $methods = array_flip(self::Methods);
        return $methods[$this->attributes['method']];
    }

    /**
     * Get the owning paymentable model.
     */
    public function transactionable()
    {
        return $this->morphTo();
    }

    public function account()
    {
        return $this->belongsTo(BankAccount::class, 'account_id', 'bank_acc_id');
    }
}
