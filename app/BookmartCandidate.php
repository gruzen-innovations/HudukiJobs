<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class BookmartCandidate extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'bookmark_candidates';
    
    protected $fillable = [
        
    ];
}