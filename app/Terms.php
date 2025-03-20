<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Terms extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'terms';
    
    protected $fillable = [
        'id', 'term'
    ];
}
