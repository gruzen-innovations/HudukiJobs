<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Feedback extends Eloquent
{
	protected $connection = 'mongodb'; 
    protected $collection = 'Feedback';
    
    protected $fillable = [
        // 'user_auto_id', 'service_booking_auto_id', 'feedback'
    ];
}
