<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Version;
use App\Admin;
use DB;
use DateTime;
use DateTimeZone;


class VersionApiController extends Controller
{
    public function index(Request $request){
         $esatatus = Admin::where('_id','=', $request->admin_auto_id)->get();
			 if($esatatus->isNotEmpty()){
                foreach($esatatus as $erase){
                     $erase_data_status=$erase->erase_data_status;
                }
			 }else{
			     $erase_data_status='No';
			 }
        if($erase_data_status =='Yes'){
    	        $versions = Version::where('admin_auto_id', $request->admin_auto_id)->get();
        }else{
             	$versions = Version::where('admin_auto_id', $request->admin_auto_id)->get();
        }
    	if($versions->isEmpty()){
    		return response()->json([
                'status' => 0, 
                'msg' => "Not Found",
            ]);
    	}
    	else{
    		return response()->json([
                'status' => 1, 
                'msg' => "Success",
                'allversion' => $versions,
                
            ]);
        }
    }			
}