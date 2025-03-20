<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class EmployeeNotification extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'employee_notifications';
    
    protected $fillable = [
      
    ];
}
?>