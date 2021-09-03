<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasFilter;

    protected $table='units';
    protected $primaryKey='unit_id';


    protected $fillable=[
        'unit_name',
        'sort_form',
        'status'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'unit_id', 'unit_id');
    }
}
