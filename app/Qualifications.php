<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Qualifications extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'Qualifications';
    
    protected $fillable = [
      
    ];
}
?>