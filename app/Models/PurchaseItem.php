<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='purchase_items';
    protected $primaryKey='item_id';

    protected $fillable=[
        'purchase_id',
        'product_id',
        'product_name',
        'product_unit',
        'item_qty',
        'pp_without_dis',
        'discount_percent',
        'item_price',
        'item_tax_id',
        'item_tax',
        'pp_inc_tax',
        'sub_total',
        'total_amount',
        'status'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'purchase_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
