<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class BusinessDetails extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'business_details';
    
    protected $fillable = [
        
    ];
}
