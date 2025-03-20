<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Banner extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'banners';
    
    protected $fillable = [
        'id', 'offer_img'
    ];
}
