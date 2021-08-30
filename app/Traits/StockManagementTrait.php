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
}
