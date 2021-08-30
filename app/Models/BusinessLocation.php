<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessLocation extends Model
{
    use HasFactory;
    use HasFilter;
    use SoftDeletes;

    protected $table='business_locations';
    protected $primaryKey='location_id';

    protected $fillable=[
        'store_name',
        'phone_no',
        'alt_phone_no',
        'landmark',
        'city',
        'zipcode',
        'state',
        'country',
        'status'
    ];

    protected $appends = ['store_address'];

    public function getStoreAddressAttribute()
    {
        $address = '';
        if (!empty($this->landmark)){
            $address .= $this->landmark.',';
        }
        if (!empty($this->city)){
            $address .= $this->city.',<br>';
        }
        if (!empty($this->state)){
            $address .= $this->state;
        }
        if (!empty($this->zip_code)){
            $address .=  '-'.$this->zipcode;
        }
        if (!empty($this->country)){
            $address .=  '-'.$this->country;
        }
        return  $address;
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'location_id', 'location_id');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'location_id', 'location_id');
    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class, 'location_id', 'location_id');
    }
}
