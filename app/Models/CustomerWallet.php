<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CustomerWallet extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'customer_wallet';
    
    protected $fillable = [
        // 'id', 'customer_id', 'amount'
    ];
}
