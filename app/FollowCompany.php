<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class FollowCompany extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'follow_unfollow_company';

    protected $fillable = [
        'employee_auto_id',
        'follow_id',
        'follow',
    ];
}
