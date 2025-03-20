<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Charges;
use DB;
use File;
use Session;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;

class ChargesController extends Controller
{
    use Features;
    use VendorPaidOrder;
    public function index(){
         
           $charges = Charges::get();
    
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
    	return view('templates.myadmin.charges')->with(['allcharges'=>$charges,'allfeatures'=>$features]);
    }
}

    public function update(Request $request){
        
        $this->validate($request,[
            'ord_amount'        => 'required',
            'tax'               => 'required',
            'refer_amount'      => 'required',
            
            
        ]);
        
      
           $charges = Charges::get();
    

    	if($charges->isNotEmpty()){
    		$charge = Charges::find($request->get('id'));
    		$charge->min_order_amount = $request->input('ord_amount');
            $charge->refer_amount = $request->input('refer_amount');
            $charge->tax = $request->input('tax');
    		$charge->save();
    		return redirect('charges')->with('success','Updated Successfully');
    	}
    	else{
    		$charges1 = new Charges();
    		$charges1->min_order_amount = $request->input('ord_amount');
            $charges1->refer_amount = $request->input('refer_amount');
            $charges1->tax = $request->input('tax');
    		$charges1->save();
    		return redirect('charges')->with('success','Added Successfully');
    	}
    }
}
