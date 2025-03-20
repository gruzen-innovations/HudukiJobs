<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class FieldFirst extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'first_field';
    
    protected $fillable = [
        
    ];
}
