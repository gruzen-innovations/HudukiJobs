<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ClassifiedAdd;
use App\ServiceFeedback;
use App\UserRegister;
use DateTimeZone;
use App\Promocode;
use App\Charges;
use App\PurchasedOrders;
use App\ImageSubscription;
use App\ImagePlans;
use App\EcommRegistration;
use App\BulkEmail;
use App\EcommPlans;
use DateTime;
use DB;

class PlansApiController extends Controller
{

  public function get_plans()
    {

              
          $get_aplists = EcommPlans::ORDERBY('sort_number','ASC')->where('status','=','Active')->whereNull('deleted_at')->get();

            if ($get_aplists->isNotEmpty()) {
                foreach ($get_aplists as $urs) {

                    $features = $urs->features;
                    $features_ids = explode(',', $features);

                    $descriptions = $urs->description;
                    $descriptions_ids = explode(',', $descriptions);

                     $months = $urs->validity * 12;

                        if($urs->validity_unit == 'Year'){
                              $per_month_price = $urs->price / $months;
                              $final_month_price = $urs->final_price / $months;
                        }else{
                              $per_month_price = '0';
                              $final_month_price = '0';
                        }


                    $get_final_lists[] = array(
                        "plan_auto_id" => $urs->_id, "plan_name" => $urs->name, "price" => $urs->price, "offer_percentage" => $urs->offer_percentage, "final_price" => strval(round($urs->final_price)),
                        "validity" => $urs->validity, "validity_unit" => $urs->validity_unit, "user_limit" => $urs->user_limit, "description" => $descriptions_ids, "status" => $urs->status, "features" => $features_ids, "country_name" => $urs->country_name, "country_code" => $urs->country_code, "currency" => $urs->currency, "code" => $urs->code,"per_month_price" => strval(round($per_month_price)), "final_month_price" => strval(round($final_month_price))
                    );
                }
                return response()->json(['status' => 1, "msg" => "success", 'get_plan_lists' => $get_final_lists]);
            } else {

                return response()->json(['status' => 0, "msg" => "No Data Available"]);
            }
        
    }

    public function place_order(Request $request) 
    {
        $vusers = PurchasedOrders::Where('plan_auto_id',$request->plan_auto_id)->where('user_auto_id', $request->user_auto_id)->Where('status',"=",'Purchased')->whereNull('deleted_at')->get();
        if($vusers->isNotEmpty()) {
			return response()->json([
                'status' => 0, 
                'msg' => 'You have already purchased this plan..!',
            ]);
		}
        else{
        $order_id = PurchasedOrders::whereNull('deleted_at')->get();
        if($order_id->isNotEmpty())
        {
            foreach ($order_id as $data) 
            {
                 $oid = $data->order_id;
            }
            if($oid!= ''){
                $str = explode("ORD",$oid,3);
                $second = $str[1];
                $naid = $second+1;
                $len = strlen($naid);
                if($len > 1){
                    $new_oid = "ORD".$naid;
                }else{
                    $new_oid = "ORD0".$naid;
                }
            }   
        }else{
            $new_oid = "ORD01";
        }
        $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));

        $order = new PurchasedOrders();
        $order->plan_auto_id = $request->plan_auto_id;
         $get_aplists = EcommPlans::where('_id','=',$request->plan_auto_id)->whereNull('deleted_at')->get();

        if($get_aplists->isNotEmpty()){
        foreach($get_aplists as $urs){
                   
                                $plan_name=$urs->name;
                                 $price=$urs->price;
                                  $offer_percentage=$urs->offer_percentage;
                                   $final_price=$urs->final_price;
                                    $validity=$urs->validity;
                                    $validity_unit=$urs->validity_unit;
                                      $description=$urs->description;
                                     $features=$urs->features;
                                    //   $features_ids = explode(',',$features);
                                 $country_id=$urs->country_id;
                                 $country_name=$urs->country_name;
                                  $country_code=$urs->country_code;
                                   $currency=$urs->currency;
                                    $code=$urs->code;
                                    $user_limit=$urs->user_limit;
        
                                      
              }
        }else{
                               $plan_name='';
                                 $price='';
                                  $offer_percentage='';
                                   $final_price='';
                                    $validity='';
                                    $validity_unit='';
                                      $description='';
                                     $features=''; 
                                     
                                      $country_id='';
                                    $country_name='';
                                      $country_code='';
                                     $currency=''; 
                                       $code='';
                                       $user_limit='';
        }
        $order->user_auto_id = $request->user_auto_id;
        $order->order_id = $new_oid;
        $order->payment_mode = $request->payment_mode;
        if($request->get('transaction_id')!=''){
                   $order->transaction_id = $request->get('transaction_id');
        }else{
                   $order->transaction_id = "";
        }
           if($request->get('transaction_status')!=''){
                   $order->transaction_status = $request->get('transaction_status');
        }else{
                   $order->transaction_status = "";
        }
         $order->plan_name = $plan_name;
        $order->price = $price;
        $order->offer_percentage = $offer_percentage;
        $order->final_price = $final_price;
        $order->validity = $validity;
        $order->validity_unit = $validity_unit;
        $order->description = $description;
        $order->features = $features;
        $order->country_id = $country_id;
        $order->country_name = $country_name;
        $order->country_code = $country_code;
        $order->currency = $currency;
        $order->user_limit = $user_limit;
        $order->code = $code;
        $order->rdate = $date->format('Y-m-d');
        $order->rtime = $date->format('H:i:s');
        $order->status = "Purchased";
        if($validity_unit == 'Year'){
           $validity_days= $validity * 365;
        }else if($validity_unit == 'Lifetime'){
            $validity_days= $validity * 365;
        }else if($validity_unit == 'Month'){
            $validity_days= $validity * 30;
        }else{
            $validity_days= $validity;
        }
        $purchased_date=$date->format('Y-m-d');
        $newdate = strtotime ( "$validity_days day" , strtotime ( $purchased_date ) ) ;
        $newdate = date ( 'Y-m-d' , $newdate );
        $order->plan_expire_date = $newdate;
        // $customerslist = EcommRegistration::where('_id',$request->get('user_auto_id'))->whereNull('deleted_at')->get();
        // if($customerslist->isNotEmpty()){
        //      foreach($customerslist as $clist){
                   
        //                         $customer_email=$clist->email;
        //                          $admin_username=$clist->admin_username;
        // }
        // }else{
        //     $customer_email = '';
        //      $admin_username = '';
        // }
        
       if($order->save()){ 

         return response()->json([
                'status' => 1, 'msg' => 'success', 'data' => $order,
            ]);
       }else{
            return response()->json([
                'status' => 0, 'msg' => 'Failed to place order',
            ]);
       }
        }
    }
     public function order_history_list(Request $request) {
		$getorderlist = PurchasedOrders::where('user_auto_id','=',$request->get('user_auto_id'))->ORDERBY('_id','DESC')->whereNull('deleted_at')->get();
		if($getorderlist->isNotEmpty()){
			return response()->json(['status' => 1, "msg" => "success...!", 'getOrderHistoryList' => $getorderlist]);
		} else {
			return response()->json(['status' => 0, "msg" => "No Data Available"]);
		}
	}

 	public function get_plan_status(Request $request){

    	$plan_status = PurchasedOrders::where('user_auto_id', $request->user_auto_id)->ORDERBY('_id','DESC')->limit(1)->whereNull('deleted_at')->get();

    	if($plan_status->isEmpty()){

    		return response()->json([

                'status' => 0, 

                'msg' => config('messages.empty'),

            ]);

    	}

    	else{
        foreach($plan_status as $vs){
           $plan_expire_date =  $vs->plan_expire_date;
        }
         $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
             $tdate = $date->format('Y-m-d');
             if($tdate >= $plan_expire_date){
                   DB::table('ecomm_purchased_orders')->where('user_auto_id', $request->user_auto_id)->update(['status' => 'Expired']);
                   $pstatus = 'Expired';
             }else{
                 $pstatus = 'Purchased';
             }
             
    		return response()->json([

                'status' => 1, 

                'msg' => config('messages.success'),

                'plan_status' => $pstatus,

            ]);

        }

    }
 

}