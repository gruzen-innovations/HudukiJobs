<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CustomerColumn extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'customer_columns';
    
    protected $fillable = [
       
    ];
}
