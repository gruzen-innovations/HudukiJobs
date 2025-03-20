<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Country extends Eloquent
{
    protected $connection = 'mongodb2'; 
    protected $collection = 'country';
    protected $fillable = [

      
   ];
}
