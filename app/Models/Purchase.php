<?php

namespace App\Models;

use App\Traits\HasAttachmentTrait;
use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasAttachmentTrait;
    use HasFilter;

    const PurchaseStatus = [
        'Received'=>1,
        'Ordered'=>2,
        'Pending'=>3,
    ];

    protected $table='purchases';
    protected $primaryKey='purchase_id';

    protected $fillable=[
        'supplier_id',
        'location_id',
        'reference_no',
        'purchase_date',
        'pay_term_type',
        'total_qty',
        'subtotal',
        'discount_type',
        'discount_amount',
        'tax_id',
        'tax_amount',
        'total_amount',
        'pay_term_number',
        'purchase_status',
        'status'
    ];

    public function supplier()
    {
        return $this->belongsTo(Contact::class, 'supplier_id', 'contact_id');
    }

    public function location()
    {
        return $this->belongsTo(BusinessLocation::class, 'location_id', 'location_id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_id', 'purchase_id');
    }
}
