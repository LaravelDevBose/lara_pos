<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimilarProduct extends Model
{
    use HasFactory;

    protected $table='similar_products';

    protected $fillable=[
        'product_id',
        'sim_prod_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function sim_product()
    {
        return $this->hasOne(Product::class, 'product_id', 'sim_prod_id');
    }
}
