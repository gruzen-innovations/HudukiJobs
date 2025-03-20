<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppBaseData;
use App\EcommPlans;
use App\Country;
use App\Categories;
use Redirect;
class AppBaseDataController extends Controller
{
      
    //ecommerce plans
    public function index_eplans(){
    	$eplans = EcommPlans::ORDERBY('sort_number','ASC')->whereNull('deleted_at')->get();
    	return view('templates.myadmin.grobiz_eplans')->with('offers',$eplans);
    }

    public function add_eplans(){
        // $country = Country::whereNull('deleted_at')->get();
        return view('templates.myadmin.add_grobiz_eplans');
    }

    public function store_eplans(Request $request){
    	$this->validate(
          $request, 
            [   
                 'name'   => 'required',
                  'price'   => 'required',
                   'offer_percentage'   => 'required',
                  'validity'   => 'required',
                  'validity_unit'   => 'required',
                   'description'   => 'required',
                  'features'   => 'required',
                
                   'user_limit'   => 'required',
                    'sort_number'   => 'required',

            ],
            [   
               
                'name.required'   => 'Enter Plan Name',
                 'price.required'   => 'Enter Price',
                'offer_percentage.required'   => 'Enter Offer Percentage',
                'validity.required'   => 'Enter Validity',
                 'validity_unit.required'   => 'Select Validity Unit',
                'description.required'   => 'Enter Description',
                'features.required'   => 'Enter Features',
               
                'user_limit.required'   => 'Enter User Limit',
		       'sort_number.required'   => 'Enter sort order',


            ]
        );
          // get country details

        // $countries = Country::where('_id','=',$request->get('country'))->whereNull('deleted_at')->get();
        // if($countries->isNotEmpty()){
        //     foreach ($countries as $cnt) {
        //         $country_name = $cnt->country_name;
        //         $country_code = $cnt->country_code;
        //         $currency = $cnt->currency;
        //         $code = $cnt->code;
        //     }
        //  }else{
              $country_name = 'India';
                $country_code = 'IN-91';
                $currency = '₹';
                 $code='INR';
         // }
        $plans = new EcommPlans();
        $plans->name = $request->input('name');
        $plans->price = $request->input('price');
        $plans->offer_percentage = $request->input('offer_percentage');
        $offer_price = ($request->price * $request->offer_percentage)/100;
        $final_price = $request->price - $offer_price;
        $plans->final_price = strval($final_price);
        $plans->validity = $request->input('validity');
        $plans->validity_unit = $request->input('validity_unit');
        $plans->description = $request->input('description');
        $plans->features = $request->input('features');
        $plans->country_id = '123456';
        $plans->user_limit = $request->input('user_limit');
        $plans->sort_number = $request->input('sort_number');
        $plans->country_name = $country_name;
        $plans->country_code = $country_code;
        $plans->currency = $currency;
        $plans->code = $code;
        $plans->status = 'Active';
        $plans->save();

         return redirect('ecomm-plans')->with('success', 'Added Successfully');
    }

    public function edit_eplans($id){
        $offer = EcommPlans::where('_id','=',$id)->whereNull('deleted_at')->get();
          // $country = Country::get();
        return view('templates.myadmin.edit_grobiz_eplans')->with(['offers' => $offer]);
    }

    public function update_eplans(Request $request){
       
    	$this->validate(
          $request, 
            [   
                 'name'   => 'required',
                  'price'   => 'required',
                   'offer_percentage'   => 'required',
                  'validity'   => 'required',
                  'validity_unit'   => 'required',
                   'description'   => 'required',
                  'features'   => 'required',
                  
                   'user_limit'   => 'required',
 		           'sort_number'   => 'required',
            ],
            [   
               
                'name.required'   => 'Enter Plan Name',
                 'price.required'   => 'Enter Price',
                'offer_percentage.required'   => 'Enter Offer Percentage',
                'validity.required'   => 'Enter Validity',
                 'validity_unit.required'   => 'Select Validity Unit',
                'description.required'   => 'Enter Description',
                'features.required'   => 'Enter Features',
              
                'user_limit.required'   => 'Enter User Limit',
		        'sort_number.required'   => 'Enter sort order',
            ]
        );
    // $countries = Country::where('_id','=',$request->get('country'))->whereNull('deleted_at')->get();
    //     if($countries->isNotEmpty()){
    //         foreach ($countries as $cnt) {
    //             $country_name = $cnt->country_name;
    //             $country_code = $cnt->country_code;
    //             $currency = $cnt->currency;
    //             $code = $cnt->code;
    //         }
    //      }else{
               $country_name = 'India';
                $country_code = 'IN-91';
                $currency = '₹';
                 $code='INR';
         // }
        $plans = EcommPlans::find($request->get('id'));
        $plans->name = $request->input('name');
        $plans->price = $request->input('price');
        $plans->offer_percentage = $request->input('offer_percentage');
        $offer_price = ($request->price * $request->offer_percentage)/100;
        $final_price = $request->price - $offer_price;
        $plans->final_price = strval($final_price);
        $plans->validity = $request->input('validity');
        $plans->validity_unit = $request->input('validity_unit');
        $plans->description = $request->input('description');
        $plans->features = $request->input('features');
        $plans->status = $request->input('status');
        $plans->country_id = '123456';
        $plans->user_limit = $request->input('user_limit');
        $plans->sort_number = $request->input('sort_number');
        $plans->country_name = $country_name;
        $plans->country_code = $country_code;
        $plans->currency = $currency;
        $plans->code = $code;
        $plans->save();
     
        return redirect('ecomm-plans')->with('success', 'Updated Successfully');
    }

    public function delete_eplans($id){
        $eplan = EcommPlans::find($id);
        $eplan->delete();
        return redirect('ecomm-plans')->with('success', 'Deleted Successfully');
    }
}