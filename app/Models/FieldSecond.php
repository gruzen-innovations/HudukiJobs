<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class FieldSecond extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'second_field';
    
    protected $fillable = [
        
    ];
}
