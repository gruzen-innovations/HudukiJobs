<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Enquiry;
use DB;
use Session;
use File;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;

class EnquiryController extends Controller
{
 	   use Features;  
      use VendorPaidOrder;
    public function index(){
   
      $enquiry = Enquiry::get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
    	return view('templates.myadmin.enquiry')->with(['enquiries' => $enquiry, 'allfeatures' => $features]);
       }
}
 
  public function delete($id){
        $enquiry = Enquiry::find($id);
        $enquiry->delete();
        return redirect('enquiry')->with('success', 'Deleted Successfully');
    }   
}
