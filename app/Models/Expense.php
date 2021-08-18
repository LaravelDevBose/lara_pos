<?php

namespace App\Models;

use App\Traits\HasAttachmentTrait;
use App\Traits\HasFilter;
use App\Traits\HasTransactionable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory;
    use HasFilter;
    use SoftDeletes;
    use HasTransactionable;
    use HasAttachmentTrait;

    const TransType = 'Cr';
    const TransModel = 'Expense';
    const total_column='total_amount';

    protected $table='expenses';
    protected $primaryKey='expense_id';

    protected $fillable=[
        'location_id',
        'head_id',
        'reference_no',
        'expense_date',
        'expense_for',
        'total_amount',
        'expense_note',
        'payment_status',
        'status',
    ];

    protected $appends=['payment_due', 'payment_status_label'];

    public function getPaymentDueAttribute()
    {
        if(!empty($this->transactions)){
            return $this->attributes['total_amount'] - $this->paidAmount();
        }else{
            return $this->attributes['total_amount'];
        }
    }
    public function getPaymentStatusLabelAttribute()
    {
        $status = array_flip(Transaction::PaymentStatus);
        return $status[$this->attributes['payment_status']];
    }

    public static function getCode()
    {
        $count = self::where('created_at', Carbon::today())->count();
        if(empty($count)){
            return 'EX'.Carbon::today()->format('md').'01';
        }else{
            return 'EX'.Carbon::today()->format('md').( ($count<9)? '0'.($count+1): ($count+1));
        }
    }

    public function head()
    {
        return $this->belongsTo(ExpanseHead::class, 'head_id', 'head_id');
    }

    public function location()
    {
        return $this->belongsTo(BusinessLocation::class, 'location_id', 'location_id');
    }

    public function expense_user()
    {
        return $this->hasOne(User::class, 'id', 'expense_for');
    }
}
