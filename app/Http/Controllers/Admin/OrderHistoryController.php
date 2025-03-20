<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Uorders;
use App\UserRegister;
use App\WholeSaler;
use DB;
use Session;
use File;
use DateTime;
use App\PurchasedOrders;
use App\MarketList;
use DateTimeZone;
use App\Traits\Features;
use App\Traits\CustomerNotification;
class OrderHistoryController extends Controller
{
    use Features;
    use CustomerNotification;
    public function index()
    {

        $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        $order_date = $date->format('Y-m-d');

            $history = PurchasedOrders::ORDERBY('_id','DESC')->where('transaction_id','!=','')->where('status','=','Purchased')->whereNull('deleted_at')->get();
            $user = UserRegister::whereNull('deleted_at')->get();
            return view('templates.myadmin.purchased_history')->with(['order_history'=>$history,'cust_details'=>$user]);
       
    }

    public function show_received_order(){
      
        $orders = Uorders::where('status','=','Received')->ORDERBY('_id','DESC')->get();
        $custs = WholeSaler::get();
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
    	return view('templates.myadmin.product_orders')->with(['allorders' => $orders,'custs' => $custs,'allfeatures' => $features]);
    }
}
    public function show_preparing_order(){
      
       $orders = Uorders::where('status','=','Preparing')->ORDERBY('_id','DESC')->get();
       $custs = WholeSaler::get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        return view('templates.myadmin.product_orders')->with(['allorders' => $orders,'custs' => $custs,'allfeatures' => $features]);
    }
}

    public function show_dispatched_order(){
    
       $orders = Uorders::where('status','=','Dispatched')->ORDERBY('_id','DESC')->get();
       $custs = WholeSaler::get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }else{
        return view('templates.myadmin.product_orders')->with(['allorders' => $orders,'custs' => $custs,'allfeatures' => $features]);
    }
}

    public function show_delivered_order(){
      
       $orders = Uorders::where('status','=','Delivered')->ORDERBY('_id','DESC')->get();
       $custs = WholeSaler::get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        return view('templates.myadmin.product_orders')->with(['allorders' => $orders,'custs' => $custs, 'allfeatures' => $features]);
    }
}
    public function show_cancelled_order(){
      
       $orders = Uorders::where('status','=','Cancelled')->ORDERBY('_id','DESC')->get();
       $custs = WholeSaler::get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        return view('templates.myadmin.product_orders')->with(['allorders' => $orders,'custs' => $custs, 'allfeatures' => $features]);
    }
}
    public function show_order_details($id){
        $orders = Uorders::where('_id','=',$id)->get();
        $wholesalers = WholeSaler::get();
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        return view('templates.myadmin.view_order_details')->with(['allorders' => $orders, 'allwholesalers' => $wholesalers,'allfeatures' => $features]);
      }
}
    public function todays_details_order(){
        $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
 		$order_date = $date->format('Y-m-d');
 		$torders = Uorders::ORDERBY('_id','=','DESC')->where('status','!=','Cancelled')->get();
        $customers = WholeSaler::get();
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        return view('templates.myadmin.todays_order_details')->with(['allorders' => $torders, 'allwholesalers' => $customers,'allfeatures' => $features]);
    }
}

    public function edit_order_status($id){
        $orders = Uorders::where('_id','=',$id)->get();
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        return view('templates.myadmin.edit_order_status')->with(['allorders' => $orders,'allfeatures' => $features]);
    }
}

    public function update_order_status(Request $request){
        $orders = Uorders::find($request->input('id'));
        $orders->status = $request->input('status');
        $orders->save();

        // get data
        $getorders = Uorders::where('_id',$request->input('id'))->get();
        if($getorders->isNotEmpty()){
            foreach ($getorders as $gorders) {
              $order_id = $gorders->order_id;
                $wholesaler_auto_id = $gorders->wholesaler_auto_id;
            }
        }
        else{
          $wholesaler_auto_id = "";
        }
        DB::table('market_lists')->where('order_id','=',$order_id)->update(['status' => $request->input('status')]);
        // get customer
        $getcustomer = WholeSaler::where('_id',$wholesaler_auto_id)->get();
        if($getcustomer->isNotEmpty()){
          foreach ($getcustomer as $cdata) {
            $vendor_auto_id = $cdata->vendor_auto_id;
            $token = $cdata->token;
          }
        }
        else{
          $vendor_auto_id = "";
          $token = "";
        }
        
     
            // send notification
              
            // Notification send to customer
            $apikey = "AAAAzUs_FVM:APA91bE_Nn28dKNriu3yubb1NTGR18U62islIg2YYpnogOU3XsrRL_RE2RHGTo9k5YOV0hSdxV8zdk4pHvCAWStuEa7pS6Ki0a2aX-oweDxcxQIttQAYs2ej1fzIpqWwgkDVWntR6rzY";
            $msg = array
            (
               "body"  =>  "Your order no. ".$order_id." has been ".$request->input('status')."",
               "title" => "Order",
               "sound" => "beep",
               "click_action" => "com.kisan.Mart",
            );
                  
            $fields = array
            (
               'to'    => $token,
               'data'  => $msg
            );
                   
            $headers = array
            (
                'Authorization: key=' . $apikey,
                'Content-Type: application/json'
            );
                   
           $ch = curl_init();
    
           curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
           curl_setopt( $ch,CURLOPT_POST, true );
           curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
           curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
           curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
           curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
           $result = curl_exec($ch );
           // print_r($result);
           if($result === FALSE){
               die('Curl failed: ' . curl_error($ch));
           }
           curl_close( $ch );
       

        if($request->input('status') == "Received"){
            return redirect('received-order-history')->with('success','Updated Successfully');
        }
        elseif($request->input('status') == "Preparing"){
            return redirect('preparing-order-history')->with('success','Updated Successfully');
        }
        elseif($request->input('status') == "Dispatched"){
            return redirect('dispatched-order-history')->with('success','Updated Successfully');
        }
        elseif($request->input('status') == "Delivered"){
            return redirect('delivered-order-history')->with('success','Updated Successfully');
        }
    }
}