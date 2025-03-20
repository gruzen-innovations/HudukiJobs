<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SaveJobs extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'save_jobs';
    
    protected $fillable = [
        
    ];
}