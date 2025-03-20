<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Settings;

use DB;

use Session;
use File;
use App\Traits\Features;

class SettingController extends Controller

{

    use Features;
    public function index(){
        
        $setting = Settings::get();
    
        $features = $this->getfeatures();

       if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

       }

       else{

    	return view('templates.myadmin.setting')->with(['settings'=>$setting,'allfeatures'=>$features]);

    }

}



    public function update(Request $request){
    
           $setting = Settings::where('vendor_auto_id','=',$vid)->get();
    
    	 $this->validate(
            $request,
             [  
               'contact' =>'required',
                'email' =>'required',
                'address' =>'required',
                'facebook' =>'required',
                'youtube' =>'required',
                'instagram' =>'required',
                'twitter' =>'required',
          
             ],
             [  
               'contact.required' =>'add contact',
                'email.required' =>'add email',
                'address.required' =>'add address',
                'facebook.required' =>'add facebook',
                'youtube.required' =>'add youtube',
                'instagram.required' =>'add instagram',
                'twitter.required' =>'add twitter',
             ]
             );

    	if($setting->isNotEmpty()){

    		$setting = Settings::find($request->get('id'));
            $setting->contact = $request->contact;
            $setting->email = $request->email;
            $setting->address = $request->address;
            $setting->facebook = $request->facebook;
            $setting->youtube = $request->youtube;
            $setting->instagram = $request->instagram;
            $setting->twitter = $request->twitter;
            $setting->save();

    		return redirect('setting')->with('success','Updated Successfully');

    	}

    	else{
             $this->validate(
            $request,
             [  
               'contact' =>'required',
                'email' =>'required',
                'address' =>'required',
                'facebook' =>'required',
                'youtube' =>'required',
                'instagram' =>'required',
                'twitter' =>'required',
          
             ],
             [  
               'contact.required' =>'add contact',
                'email.required' =>'add email',
                'address.required' =>'add address',
                'facebook.required' =>'add facebook',
                'youtube.required' =>'add youtube',
                'instagram.required' =>'add instagram',
                'twitter.required' =>'add twitter',
             ]
             );
    		$setting = new Settings();
    		$setting->contact = $request->contact;
            $setting->email = $request->email;
            $setting->address = $request->address;
            $setting->facebook = $request->facebook;
            $setting->youtube = $request->youtube;
            $setting->instagram = $request->instagram;
            $setting->twitter = $request->twitter;
            $setting->save();

    		return redirect('setting')->with('success','Added Successfully');

    	}

    }

  

   
}

