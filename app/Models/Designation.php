<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Designation extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'designations';
    
    protected $fillable = [
    ];
}
