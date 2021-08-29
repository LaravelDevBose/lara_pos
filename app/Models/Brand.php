<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory;
    use HasFilter;
    use SoftDeletes;

    const Columns = [
        'name'=>'brand_name'
    ];

    protected $table='brands';
    protected $primaryKey='brand_id';

    protected $fillable=[
        'brand_name',
        'status'
    ];

    public function product()
    {
        return $this->hasMany(Product::class, 'brand_id', 'brand_id');
    }
}
