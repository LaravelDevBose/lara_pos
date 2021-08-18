<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use HasFilter;
    use SoftDeletes;

    const PayTerms = [
        'Days'=>1,
        'Monthly'=>2,
    ];

    protected $table='contacts';
    protected $primaryKey='contact_id';

    protected $fillable =[
        'unique_code',
        'contact_type', // customer/supplier
        'first_name',
        'last_name',
        'business_name',
        'mobile_no',
        'alt_phone_no',
        'email',
        'contact_dob',
        'open_balance',
        'pay_term_num',
        'pay_term_type',
        'credit_limit',
        'address_line',
        'city',
        'state',
        'country',
        'zip_code',
        'status'
    ];

    protected $appends=['address', 'pay_term'];

    public function getAddressAttribute()
    {
        $address = '';
        if (!empty($this->address_line)){
            $address .= $this->address_line.',';
        }
        if (!empty($this->city)){
            $address .= $this->city.',';
        }
        if (!empty($this->state)){
            $address .= $this->state;
        }
        if (!empty($this->zip_code)){
            $address .=  '-'.$this->zip_code;
        }
        if (!empty($this->country)){
            $address .=  '-'.$this->country;
        }
        return  $address;
    }

    public function getPayTermAttribute()
    {
        if(!empty($this->attributes['pay_term_num'])){
            $type = array_flip(self::PayTerms);
            return $this->attributes['pay_term_num']. ' '. $type[$this->attributes['pay_term_type']];
        }
        return  '';
    }


    public function scopeOnlyCustomer($q)
    {
        return $q->where('contact_type', 'customer');
    }

    public function scopeOnlySuppler($q)
    {
        return $q->where('contact_type', 'supplier');
    }

    public function scopeTypeWise($q, $type)
    {
        return $q->where('contact_type', $type);
    }

    public function scopeSearchBy($query, $request)
    {
        if(!empty($request->type)){
            $query = $query->where('contact_type', $request->type);
        }

        return $query;
    }

    public static function getCode($type='customer')
    {
        if($type == 'customer'){
            $char = 'C0';
        }else{
            $char = 'S0';
        }
        $count = Contact::where('contact_type', $type)->count();
        if(empty($count)){
            return $char.'1';
        }else{
            return $char.($count+1);
        }
    }

}
