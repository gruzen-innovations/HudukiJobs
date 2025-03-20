<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\NotificationSettings;
use DB;
use Session;
use File;
use App\Traits\Features;

class NotificationSettingsController extends Controller
{
    use Features;

    public function index(){
        
       $setting = NotificationSettings::get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }else{
    	return view('templates.myadmin.notification_setting')->with(['notification_settings'=>$setting,'allfeatures'=>$features]);
      }
}

    public function update(Request $request){
    
        $setting = NotificationSettings::get();
    	if($setting->isNotEmpty()){
          $this->validate(
          $request, 
            [   
                'package_name' => 'required',
                'key' => 'required',
            ],
            [   
                'package_name.required' => 'Enter Package Name',
                'key.required' => 'Enter Key',
            ]
          );
    		$setting = NotificationSettings::find($request->get('id'));
    		$setting->package_name = $request->package_name;
            $setting->key = $request->key;
    		$setting->save();
    		return redirect('notification-setting')->with('success','Updated Successfully');
    	}
    	else{
          $this->validate(
          $request, 
            [   
                'package_name' => 'required',
                'key' => 'required',
            ],
            [   
                'package_name.required' => 'Enter Package Name',
                'key.required' => 'Enter Key',
            ]
          );
    		$setting = new NotificationSettings();
    		$setting->package_name = $request->package_name;
            $setting->key = $request->key;
    		$setting->save();
    		return redirect('notification-setting')->with('success','Added Successfully');
    	}
    }
}
