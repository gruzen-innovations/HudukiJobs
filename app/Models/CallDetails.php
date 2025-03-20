<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CallDetails extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'call_details';
    
    protected $fillable = [
        
    ];
}
