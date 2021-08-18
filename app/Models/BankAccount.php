<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use HasFactory;
    use HasFilter;
    use SoftDeletes;

    const AccountTypes = [
        'Current Account'=>1,
        'Saving Account'=>2,
        'Mobile Banking'=>3,
        'Online Banking'=>4,
    ];

    protected $table='bank_accounts';
    protected $primaryKey='bank_acc_id';

    protected $fillable=[
        'account_name',
        'acc_holder_name',
        'account_number',
        'account_type',
        'opening_balance',
        'account_details',
        'account_note',
        'status'
    ];

    protected $casts=['account_details'];

    protected $appends = ['account_class', 'account_info'];
    public function getAccountDetailsAttribute()
    {
        return json_decode($this->attributes['account_details'], true);
    }
    public function getAccountClassAttribute()
    {
        $types = array_flip(self::AccountTypes);
        return $types[$this->attributes['account_type']];
    }

    public function getAccountInfoAttribute()
    {
        return $this->attributes['account_name']. ' ( Balance: '.number_format($this->attributes['opening_balance'], 2). ' )';
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'account_id', 'bank_acc_id');
    }
}
