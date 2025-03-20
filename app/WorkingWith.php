<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class WorkingWith extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'job_skills';
    
    protected $fillable = [
      
    ];
}
?>