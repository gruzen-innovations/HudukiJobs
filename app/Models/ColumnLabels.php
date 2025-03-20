<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ColumnLabels extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'columns_labels';
    
    protected $fillable = [
       
    ];
}