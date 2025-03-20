<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Enquiry extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'enquiries';
    
    protected $fillable = [
        'id','name', 'email', 'contact','type', 'message', 'created_at'
    ];
}
