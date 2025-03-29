<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CandidateRemainder extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'candidate_remainder';

    protected $fillable = [
        'employee_auto_id',
        'employer_auto_id',
        'call_date',
        'call_time',
    ];
}
