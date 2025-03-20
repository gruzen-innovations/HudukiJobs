<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Subtasks extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'sub_tasks';
    
    protected $fillable = [
    ];
}
