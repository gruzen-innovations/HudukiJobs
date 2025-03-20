<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Categories extends Eloquent
{
	protected $connection = 'mongodb'; 
    protected $collection = 'Categories';
    
    protected $fillable = [
        
    ];
}
