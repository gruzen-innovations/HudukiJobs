<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ReportEmployee extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'report_employee';

    protected $fillable = [
        'employee_auto_id',
        'employer_auto_id',
        'reason',
    ];
}
