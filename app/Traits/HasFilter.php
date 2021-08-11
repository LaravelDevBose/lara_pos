<?php
/*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/

namespace App\Traits;


use Carbon\Carbon;

trait HasFilter
{

    public function scopeNotDelete($query)
    {
        return $query->where('status', '!=', config('constant.delete'));
    }

    public function scopeIsActive($query)
    {
        return $query->where('status', config('constant.active'));
    }

    public function scopeIsLive($query)
    {
        return $query->whereDate(self::Columns['start_at'], '<=', Carbon::now())
            ->whereDate(self::Columns['end_at'], '>=', Carbon::now());
    }

    public function scopeSorting($query, $request)
    {
        if(!empty($request->sort_by)) {
            if (!empty($request->order_by) && !empty(self::Columns[$request->order_by])){
                $query = $query->orderBy(self::Columns[$request->order_by], $request->sort_by);
            }else{
                $query = $query->orderBy($this->primaryKey, $request->sort_by);
            }
        }else{
            if(empty($request->latest)){
                $query = $query->latest();
            }
        }

        return $query;
    }

    public function scopeSearchBy($query, $request)
    {
        if(!empty($request->search_key)){
            $query->where(self::Columns['name'], 'like', '%'.$request->search_key.'%');
        }

        return $query;
    }
}
