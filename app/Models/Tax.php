<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasFilter;
 
    protected $table='taxes';
    protected $primaryKey='tax_id';


    protected $fillable=[
        'tax_title',
        'tax_percent',
        'status'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'tax_id', 'tax_id');
    }
}
