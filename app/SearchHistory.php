<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SearchHistory extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'serach_history';

    protected $fillable = [
        'employee_auto_id', 
        'job_skill',
        'job_role',
        'location',
        'walkin_interview', 
    ];

    public static function boot()
    {
        parent::boot();

        // Ensure employee_auto_id is always required
        static::creating(function ($model) {
            if (empty($model->employee_auto_id)) {
                throw new \Exception("employee_auto_id is required");
            }
        });
    }
}
