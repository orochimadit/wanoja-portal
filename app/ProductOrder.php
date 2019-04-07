<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    //
    protected $table = 'order_product';

    protected $fillable = [
        'product_id', 'order_id', 'quantity'
    ];
}
