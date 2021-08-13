<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpanseHead extends Model
{
    use HasFactory;
    use HasFilter;
    use SoftDeletes;

    protected $table='expanse_heads';
    protected $primaryKey='head_id';

    protected $fillable=[
        'head_title',
        'head_note',
        'status'
    ];
}
