<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CustomerAttachment extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'customer_attachments';
    
    protected $fillable = [
       
    ];
}
