<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class VideoCall extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'VideoCall';
    
    protected $fillable = [
        
    ];
}
