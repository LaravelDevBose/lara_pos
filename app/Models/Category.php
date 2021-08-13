<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use HasFilter;
    use SoftDeletes;

    const Columns = [
        'name'=> 'category_name'
    ];

    protected $table='categories';
    protected $primaryKey='category_id';

    protected $fillable=[
        'category_name',
        'parent_id',
        'status'
    ];

    public function scopeOnlyParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public static function get_all_children_ids($catIds)
    {
        $sedChildID = self::whereIn('parent_id', $catIds)->pluck('category_id')->toArray();
        if(!empty($sedChildID)){
            $catIds = array_merge($catIds, $sedChildID);
        }
        return $catIds;
    }

    public function scopeSearchBy($query, $request)
    {
        if (!empty($request->parent_id)){
            $query = $query->where('parent_id', $request->parent_id);
        }else{
            $query = $query->whereNull('parent_id');
        }
        if(!empty($request->search_key)){
            $query = $query->where('category_name', 'LIKE', '%'.$request->search_key. '%');
        }

        return $query;
    }

    public function children(){
        return $this->hasMany(Category::class, 'parent_id', 'category_id');
    }

    public function parent(){
        return $this->hasOne(Category::class, 'category_id', 'parent_id');
    }
}
