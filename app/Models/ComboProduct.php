<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComboProduct extends Model
{
    use HasFactory;

    protected $table='combo_products';

    protected $fillable=[
        'product_id',
        'comb_prod_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function comb_product()
    {
        return $this->hasOne(Product::class, 'product_id', 'comb_prod_id');
    }

}
