<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class About extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'abouts';
    
    protected $fillable = [
        'id', 'about'
    ];
}
