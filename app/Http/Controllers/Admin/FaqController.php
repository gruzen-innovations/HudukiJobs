<?php



namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Faq;

use DB;
use File;
use Session;

use App\Traits\Features;

class FaqController extends Controller

{
     use Features;  
        public function index(){
    	
      
           $fq = Faq::get();
    
          $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        return view('templates.myadmin.faq')->with(['faqs'=>$fq,'allfeatures' => $features]);
        }

}



    public function update(Request $request){
    
         $fq = Faq::get();
    
         $this->validate(
            $request,
             [  
               'faq' =>'required',
          
             ],
             [  
               'faq.required' =>'add faq',
           
             ]
             );
    	if($fq->isNotEmpty()){

    		$fq = Faq::find($request->get('id'));

    		$fq->faq = $request->faq;

    		$fq->save();

    		return redirect('faq')->with('success','Updated Successfully');

    	}

    	else{
             $this->validate(
            $request,
             [  
               'faq' =>'required',
          
             ],
             [  
               'faq.required' =>'add faq',
           
             ]
             );
    		$fq = new Faq();
    		$fq->faq = $request->faq;
    		$fq->save();

    		return redirect('faq')->with('success','Added Successfully');

    	}

    }

  

   
}

