<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Charges extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'charges';
    
    protected $fillable = [
        'id', 'order_amount'
    ];
}
