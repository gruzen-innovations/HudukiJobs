<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;



class Version extends Eloquent

{

    protected $connection = 'mongodb'; 

    protected $collection = 'versions';

    

    protected $fillable = [

      

    ];

}

