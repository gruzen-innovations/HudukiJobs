<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Employee extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'employee_details';
    
    protected $fillable = [
        // 'id', 'currency' ,'country_name'
    ];
}