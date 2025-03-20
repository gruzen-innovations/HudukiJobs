<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Membership extends Eloquent
{
	protected $connection = 'mongodb'; 
    protected $collection = 'memberships';
    
    protected $fillable = [
        
    ];
}
