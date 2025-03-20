<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class MembershipBooking extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'membership_bookings';
    
    protected $fillable = [
        // 'id', 'order_amount'
    ];
}
