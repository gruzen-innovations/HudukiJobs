<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class RecruiterAction extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'recruter_actions';
    
    protected $fillable = [
        
    ];
}