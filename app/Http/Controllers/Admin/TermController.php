<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Terms;

use DB;

use Session;

use App\Traits\Features;

class TermController extends Controller

{

    use Features;
    public function index(){
    
           $terms = Terms::get();
    

        $features = $this->getfeatures();

       if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

       }

       else{

    	return view('templates.myadmin.term_condition')->with(['allterms'=>$terms,'allfeatures'=>$features]);

    }

}



    public function update(Request $request){
    
           $terms = Terms::get();
    
    	 $this->validate(
            $request,
             [  
               'term' =>'required',
          
             ],
             [  
               'term.required' =>'add  term and condition',
           
             ]
             );

    	if($terms->isNotEmpty()){

    		$terms = Terms::find($request->get('id'));

    		$terms->term = $request->term;

    		$terms->save();

    		return redirect('term-condition')->with('success','Updated Successfully');

    	}

    	else{
             $this->validate(
            $request,
             [  
               'term' =>'required',
          
             ],
             [  
               'term.required' =>'add  term and condition',
           
             ]
             );
    		$terms = new Terms();
    		$terms->term = $request->term;

    		$terms->save();

    		return redirect('term-condition')->with('success','Added Successfully');

    	}

    }

  

   
}

