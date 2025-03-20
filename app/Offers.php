<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Offers extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'offers';
    
    protected $fillable = [
    ];
}
