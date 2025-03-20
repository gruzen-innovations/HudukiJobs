<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class TaskComments extends Eloquent
{
  protected $connection = 'mongodb'; 
    protected $collection = 'task_comments';
    
    protected $fillable = [
        
    ];
}
