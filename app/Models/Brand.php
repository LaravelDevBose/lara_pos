<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    use HasFilter;

    const Columns = [
        'name'=>'brand_name'
    ];

    protected $table='brands';
    protected $primaryKey='brand_id';

    protected $fillable=[
        'brand_name',
        'status'
    ];
}
