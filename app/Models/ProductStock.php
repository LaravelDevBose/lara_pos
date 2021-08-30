<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStock extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='product_stocks';
    protected $primaryKey='stock_id';

    protected $fillable=[
        'location_id',
        'product_id',
        'current_stock',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function location()
    {
        return $this->belongsTo(BusinessLocation::class, 'location_id', 'location_id');
    }
}
