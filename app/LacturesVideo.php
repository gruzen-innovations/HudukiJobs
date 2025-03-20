<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class LacturesVideo extends Eloquent
{ 
	protected $connection = 'mongodb'; 
    protected $collection = 'LacturesVideo';
    
    protected $fillable = [
        
    ];
}
//db.LacturesVideo.insert({ bord_id:"5ea9710d916722ed22106421",bord_name:"CBSC",class_id:"5ea97510916722ed22106423",class_name:"10th",subject_id:"5eaa60f01f7c010800007d70",subject:"Math",chapter_id:"5eaa9b55e61b0a50690bad51",chapter:"Circle",topic:'Circle formulas',video_url:"a-7A1lWTqvQ",details:'Hello this is fomula',status:"Active",rdate:"2020-12-12"})

