<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pincode;
use DB;
use Session;
use File;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;

class PincodeController extends Controller
{
 use Features;
  use VendorPaidOrder;
  public function show_add(){
    
    $pincode = Pincode::get();
    
    $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
      return view('templates.myadmin.add_pincode')->with(['allpincode'=>$pincode, 'allfeatures'=> $features]);
  }
}
	public function index(){
    
    $pincode = Pincode::get();
    
    $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
		  return view('templates.myadmin.pincode')->with(['allpincode'=>$pincode,'allfeatures'=> $features]);
  }
}

   	public function store( Request $request){
   		$this->validate($request, 
        [   
            'pincode' => 'required',
            'dcharge' => 'required',
        ],
        [ 
            'pincode.required' => 'Please enter pincode',
            'dcharge.required' => 'Please enter delivery charge',
        ]);
   		$pincode = new Pincode();
   		$pincode->pincode = $request->input('pincode');
   		$pincode->delivery_charge = $request->input('dcharge');
   		$pincode->save();
   		return redirect('pincode')->with('allpincode',$pincode);
   	}

   	public function edit($id){
   		$pincode = Pincode::where('_id','=',$id)->get();
     $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
   		return view('templates.myadmin.edit_pincode')->with(['allpincode'=>$pincode,'allfeatures' => $features]);
   	}
   }

   	public function update(Request $request){
   		$this->validate($request, 
        [   
            'pincode' => 'required',
            'dcharge' => 'required',
        ],
        [ 
            'pincode.required' => 'Please enter pincode',
            'dcharge.required' => 'Please enter delivery charge',
        ]);

   		$pincode = Pincode::find($request->input('id'));
   		$pincode->pincode = $request->input('pincode');
   		$pincode->delivery_charge = $request->input('dcharge');
   		$pincode->save();
   		return redirect('pincode')->with('success', 'Updated Successfully');
   	}

   	public function delete($id){
   		$pincode = Pincode::find($id);
   		$pincode->delete();
   		return redirect('pincode')->with('success', 'Deleted Successfully');
   	}
}
