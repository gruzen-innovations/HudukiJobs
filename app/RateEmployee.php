<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class RateEmployee extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'employee_rating';

    protected $fillable = [
        'employee_auto_id',
        'employer_auto_id',
        'rate',
    ];
}
