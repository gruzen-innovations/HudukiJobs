<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Notifications extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'Notifications';
    
    protected $fillable = [
      
    ];
}
?>