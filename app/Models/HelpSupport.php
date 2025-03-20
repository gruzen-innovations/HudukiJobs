<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class HelpSupport extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'help_supports';
    
    protected $fillable = [
       
    ];
}
