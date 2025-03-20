<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Users extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'UserRegister';
    
    protected $fillable = [
        // 'id', 'user_id', 'name','email', 'contact', 'country_code', 'type','status', 'clinic_name', 'clinic_address','password','token','otp','otp_status'
    ];
}
