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

class ExpressDeliveryController extends Controller
{
    use Features;
    use VendorPaidOrder;
    public function index(){
        $ed = Charges::get();
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }else{
    	return view('templates.myadmin.express_delivery')->with(['alledcharges'=>$ed,'allfeatures'=>$features]);
       }
}

    public function update(Request $request){
        
        $this->validate($request,[
            'express_delivery_charges' =>'required',
            'express_delivery_time' =>'required',
        ]);
        
      
        $charges = Charges::get();
    	if($charges->isNotEmpty()){
    		$charge = Charges::find($request->get('id'));
    		$charge->express_delivery_charges = $request->input('express_delivery_charges');
		    $charge->express_delivery_time = $request->input('express_delivery_time');
            $charge->save();
    		return redirect('expressDelivery')->with('success','Updated Successfully');
    	}
    	else{
    		$charges1 = new Charges();
    		$charges1->express_delivery_charges = $request->input('express_delivery_charges');
            $charges1->express_delivery_time = $request->input('express_delivery_time');
            $charges1->save();
    		return redirect('expressDelivery')->with('success','Added Successfully');
    	}
    }
}
