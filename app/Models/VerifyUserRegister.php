<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class VerifyUserRegister extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'verify_users_contact';
    
    protected $fillable = [
        // 'id', 'doctor_id', 'name','email', 'contact', 'country_code', 'doctor_name','status', 'clinic_name', 'password','token','otp','otp_status'
    ];
}
