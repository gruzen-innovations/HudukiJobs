<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CrmSlider extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'crm_slider';
    
    protected $fillable = [
    ];
}
