<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AppliedJobs extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'applied_jobs';
    
    protected $fillable = [
        
    ];
}