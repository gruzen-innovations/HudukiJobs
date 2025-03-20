<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class PurchasedOrders extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'purchased_plans';
    
    protected $fillable = [
    ];
}
