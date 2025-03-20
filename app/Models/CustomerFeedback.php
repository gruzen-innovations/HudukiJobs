<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CustomerFeedback extends Eloquent
{
    protected $connection = 'mongodb'; 
    protected $collection = 'CustomerFeedback';
    
    protected $fillable = [
       'id','user_auto_id','message'
    ];
}
