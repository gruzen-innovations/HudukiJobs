<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class RatingReview extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'rating_review';
    
    protected $fillable = [
        // 'id', 'order_amount'
    ];
}
