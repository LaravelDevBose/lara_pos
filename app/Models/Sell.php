<?php

namespace App\Models;

use App\Traits\HasAttachmentTrait;
use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sell extends Model
{
    use HasFactory;
    use HasAttachmentTrait;
    use SoftDeletes;
    use HasFilter;

    const SellStatus = [
        'Final'=>1,
        'Draft'=>2,
        'Quotation'=>3,
    ];

    const ShippingStatus=[
        'Ordered'=>1,
        'Packed'=>2,
        'Shipped'=>3,
        'Delivered'=>4,
        'Cancel'=>5
    ];

    protected $table='sells';
    protected $primaryKey='sell_id';

    protected $fillable=[
        'location_id',
        'customer_id',
        'reference_no',
        'sell_date',
        'total_qty',
        'discount_type',
        'discount_amount',
        'subtotal',
        'tax_id',
        'tax_amount',
        'shipping_charge',
        'total_amount',
        'pay_term_number',
        'pay_term_type',
        'sale_note',
        'shipping_details',
        'shipping_address',
        'shipping_status',
        'sell_status',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Contact::class, 'customer_id', 'contact_id');
    }

    public function location()
    {
        return $this->belongsTo(BusinessLocation::class, 'location_id', 'location_id');
    }

    public function items()
    {
        return $this->hasMany(SellItem::class, 'sell_id', 'sell_id');
    }
}
