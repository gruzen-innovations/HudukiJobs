<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class PriorityLabel extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'priority_labels';
    
    protected $fillable = [
       
    ];
}