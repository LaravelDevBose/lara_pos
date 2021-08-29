<?php

namespace App\Models;

use App\Traits\HasAttachmentTrait;
use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use HasAttachmentTrait;
    use SoftDeletes;
    use HasFilter;

    const TYPES = [
        'Single'=>1,
        'Combo'=>2
    ];

    protected $table='products';
    protected $primaryKey='product_id';

    protected $fillable=[
        'category_id',
        'brand_id',
        'barcode',
        'product_reference',
        'short_description',
        'long_description',
        'profit_margin',
        'product_tva',
        'min_stock',
        'max_stock',
        'product_type',
        'status'
    ];

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
}
