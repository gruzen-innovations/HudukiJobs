<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Jobs extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'jobs';
    
    protected $fillable = [
        
    ];
}