<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Slider extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'sliders';
    
    protected $fillable = [
        'id','sname', 'image','main_category_auto_id','main_category_name_english','sub_category_auto_id','sub_category_name'
    ];
}
