<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Faq extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'faqs';
    
    protected $fillable = [
        'id', 'faq'
    ];
}
