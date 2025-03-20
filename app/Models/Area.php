<?php
namespace App\Models;



use Illuminate\Database\Eloquent\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;



class Area extends Eloquent

{

    protected $connection = 'mongodb'; 

    protected $collection = 'area';

    

   
}
