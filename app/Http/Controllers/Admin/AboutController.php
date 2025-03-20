<?php



namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\About;

use DB;

use Session;
use File;
use App\Traits\Features;

class AboutController extends Controller

{
     use Features;
        public function index(){
    
           $about = About::get();
   
          $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        return view('templates.myadmin.about')->with(['abouts'=>$about,'allfeatures' => $features]);
        }
    }



    public function update(Request $request){
       
           $about = About::get();
    
       
            $this->validate(
          $request, 
            [   
                'about' => 'required',
            ],
            [   
                'about.required' => 'Add about us',
            ]
          );
       
                
            

    	if($about->isNotEmpty()){

    		$about = About::find($request->get('id'));

    		$about->about = $request->about;
          
    		$about->save();

    		return redirect('about')->with('success','Updated Successfully');

    	}

    	else{
        $this->validate(
         $request,
           [  
            'about' =>'required',
            
           ],
           [  
            'about.required' =>'add About',
          
             ]
             );
    		$about = new About();
          
    		$about->about = $request->about;

    		$about->save();

    		return redirect('about')->with('success','Added Successfully');

    	}

    }

  

   
}

