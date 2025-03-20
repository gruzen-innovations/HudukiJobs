<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class UserRegister extends Eloquent
{
	protected $connection = 'mongodb'; 
    protected $collection = 'UserRegister';
    
    protected $fillable = [
    //   'id','trainer_id','name','trainer_name','email','mobile_number','password','token','status'
    ];
}
