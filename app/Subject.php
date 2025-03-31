<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Subject extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'subject';

    protected $fillable = [
    ];
}
