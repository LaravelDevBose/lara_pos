<?php

namespace App\Models;

use App\Traits\HasAttachmentTrait;
use App\Traits\HasFilter;
use App\Traits\StockManagementTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use HasAttachmentTrait;
    use SoftDeletes;
    use HasFilter;
    use StockManagementTrait;

    const TYPES = [
        'Single'=>1,
        'Combo'=>2
    ];

    const Units = [
        'Pcs'=>1,
        'Kg'=>2,
        'GM'=>3
    ];

    protected $table='products';
    protected $primaryKey='product_id';

    protected $fillable=[
        'category_id',
        'brand_id',
        'barcode',
        'product_name',
        'product_reference',
        'unit_id',
        'short_description',
        'long_description',
        'profit_margin',
        'product_tva',
        'min_stock',
        'max_stock',
        'product_type',
        'status'
    ];

    protected $appends=['current_stock', 'product_info', 'unit_label'];

    public function getProductInfoAttribute()
    {
        $units = array_flip(self::Units);
        return $this->attributes['product_reference'].'-'.$this->product_stock().' '.$units[$this->attributes['unit_id']].' (s) ';
    }

    public function getUnitLabelAttribute()
    {
        $units = array_flip(self::Units);
        return $units[$this->attributes['unit_id']];
    }

    public function scopeSearchBy($query, $request)
    {

        if (!empty($request->category_id)){
            $query = $query->where('category_id', $request->category_id);
        }

        if(!empty($request->brand_id)){
            $query = $query->where('brand_id', $request->brand_id);
        }

        if(!empty($request->search_key)){
            $search_key = $request->search_key;
            // dd($search_key);
            $query = $query->where('product_reference', 'like', '%'.$search_key.'%')
                ->orWhere('short_description', 'like', '%'. $search_key.'%');
                // ->orderByRaw("IF('product_reference' = '{$search_key}',2,IF(product_reference LIKE '%{$search_key}%',1,0)) DESC, length(product_reference)");
        }
        return $query;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'brand_id');
    }

    public function combo_products()
    {
        return $this->hasMany(ComboProduct::class, 'comb_prod_id', 'product_id');
    }

    public function combos()
    {
        return $this->belongsToMany(Product::class, 'combo_products', 'product_id', 'comb_prod_id');
    }

    public function similar_products()
    {
        return $this->hasMany(SimilarProduct::class, 'sim_prod_id', 'product_id');
    }

    public function similars()
    {
        return $this->belongsToMany(Product::class, 'similar_products', 'product_id', 'sim_prod_id');
    }

    public function pruchase_items()
    {
        return $this->hasMany(PurchaseItem::class, 'product_id', 'product_id');
    }

    public function sell_items()
    {
        return $this->hasMany(SellItem::class, 'product_id', 'product_id');
    }

    //product show on purchase page
    public function scopePurchase($q, $id)
    {
        return $q->where('product_id', $id)->first();
    }
}
