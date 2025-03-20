<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Admin extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'admin_login';
    
    protected $fillable = [
         'id', 'admin_id', 'name', 'username', 'email', 'contact', 'password'
    ];
}

// db.admin_login.insert({admin_id:"5f48abc98e4a523a92553562", name:"ramji", admin_username: "VeLaTePaLa362", email: "velatepela@gmail.com", contact: "9824324981", admin_password: "$2y$10$ap2snRXTZW.aeK6gXR.tYuhUcQaOA3vixXmB1d/v6UhIxIfIipUji"})

// password : Xyz12345