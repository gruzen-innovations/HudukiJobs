<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class userWorkDetails extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'employee_work_details';
    
    protected $fillable = [
      
    ];
}
?>