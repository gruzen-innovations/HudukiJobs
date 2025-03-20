<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
class PurchasedOrders extends Eloquent
{
 use SoftDeletes;
    protected $connection = 'mongodb'; 
    protected $collection = 'ecomm_purchased_orders';
    
    protected $fillable = [
        
    ];
}
