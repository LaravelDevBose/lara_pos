<?php

namespace App\Models;

use App\Traits\StockManagementTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    use StockManagementTrait;

    protected $table='sell_items';
    protected $primaryKey='item_id';

    protected $fillable=[
        'sell_id',
        'product_id',
        'product_name',
        'product_note',
        'product_unit',
        'item_qty',
        'item_price',
        'discount_type',
        'discount_amount',
        'sub_total',
        'item_tax_id',
        'item_tax',
        'price_inc_tax',
        'total_amount',
        'status'
    ];

    public function sell()
    {
        return $this->belongsTo(Sell::class, 'sell_id', 'sell_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
