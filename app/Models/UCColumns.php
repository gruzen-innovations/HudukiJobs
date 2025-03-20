<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class UCColumns extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'user_colums';
    
    protected $fillable = [
    ];
}
