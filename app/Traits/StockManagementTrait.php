<?php
/*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/

namespace App\Traits;

use App\Models\ProductStock;

trait StockManagementTrait
{

    public function stocks()
    {
        return $this->hasMany(ProductStock::class, 'product_id', 'product_id');
    }

    public function getCurrentStockAttribute()
    {
        if(!empty($this->stocks)){
            return $this->stocks()->sum('stock');
        }
        return 0;

    }

    public function product_stock()
    {
        if(!empty($this->stocks)){
            return $this->stocks()->sum('stock');
        }
        return 0;
    }
}
