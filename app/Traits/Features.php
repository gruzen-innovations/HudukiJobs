<?php

namespace App\Traits;

use App\Uorders;
use Session;

trait Features
{
	public function getfeatures()
    {
// 		$get_customer_order_details = Uorders::where('customer_id','=',Session::get('AccessToken'))->Where('main_category_id','MCAT01')->get();
// 	     if($get_customer_order_details->isNotEmpty()){
// 	         foreach ($get_customer_order_details as $customer_details) {
// 	             $fdata = $customer_details->feature_name;
// 	         }
  	$fdata = "Registration|Login|Profile|Products|Cart|Wishlist|Order History|Wallet Transfer|Transaction History|Cancel Order|Wallet";
	        if($fdata!=''){
	            $features = explode('|',$fdata);
	            return $features;
	        }
	        else{
	        	$features = array();
	            return $features;
	        }
	   // }
	   // else{
	   // 	$features = array();
	   //     return $features;
	   // }
	}
}
