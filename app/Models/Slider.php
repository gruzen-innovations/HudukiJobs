<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Slider extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'crm_sliders';
    
    protected $fillable = [
        // 'id','sname', 'image'
    ];
}
