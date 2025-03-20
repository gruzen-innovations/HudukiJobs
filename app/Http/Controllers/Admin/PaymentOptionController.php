<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Plans;
use App\StorageSpaceCount;
use App\NotificationCount;
use App\Traits\Features;
use App\Traits\StorageSpace;
use App\PaymentOption;
use Session;
use File;
use App\PurchasePaymentGateway;
use App\Traits\VendorPaidOrder;

class PaymentOptionController extends Controller
{
    use Features;
    use StorageSpace;
     use VendorPaidOrder;
    public function payment_options(Request $request){
        $get_all_methods = PaymentOption::Where('status','Unblock')->get();
        if($get_all_methods->isEmpty()){
            $get_all_methods = array();
        }
      
        
           $get_purchased_gateways = PurchasePaymentGateway::get();
    
        if($get_purchased_gateways->isEmpty()){
            $get_purchased_datagateways = array();
        }else{
            foreach($get_purchased_gateways as $data1){
                $get_purchased_datagateways[] = $data1->gateway_id;
            }
        }
         $features = $this->getfeatures();

        if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

        }
        else{
             return view('templates.myadmin.payment_options')->with(['all_payment_methods'=>$get_all_methods,'get_purchased_gateways'=>$get_purchased_datagateways,'allfeatures'=> $features]);
        }
    }
    
    
    public function gatewayDetails($id){
          $get_all_methods = PaymentOption::Where('status','Unblock')->Where('_id',$id)->get();
        if($get_all_methods->isEmpty()){
             return redirect('payment_options');
        }else{
         
            foreach($get_all_methods as $data){
                $gateway_name = $data->gateway;
            }
        $features = $this->getfeatures();

        if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

        }

        else{
             return view('templates.myadmin.gatewayDetails')->with(['all_payment_methods'=>$get_all_methods,'gateway_name'=>$gateway_name,'allfeatures'=> $features]);
         }
        }
    }
        
    public function saveGatewayDetails(Request $request){
        

        if($request->input('id') == ''){
             return redirect('payment_options')->with(['error'=>'Something went wrong']);
        }else{
            $id = $request->input('id');
             $get_all_methods = PaymentOption::Where('status','Unblock')->Where('_id',$id)->get();
             
                if($get_all_methods->isEmpty()){
                     return redirect('payment_options');
                }else{
                 
                    foreach($get_all_methods as $data){
                        $gateway_name = $data->gateway;
                    }
                    
                    
                    if($gateway_name == 'Paytm'){
                        
                        $this->validate($request,[
                            'paytm_merchant_id'   => 'required',
                            'paytm_merchant_key'  => 'required',
                            'paytm_merchant_website' => 'required',
                            'industry_type_id'   => 'required',
                              
                        ]); 
                        $credentials_array = array('paytm_merchant_id'=>$request->input('paytm_merchant_id'),'paytm_merchant_key'=>$request->input('paytm_merchant_key'),'paytm_merchant_website'=>$request->input('paytm_merchant_website'),'industry_type_id'=>$request->input('industry_type_id'));
                        
                        $PurchasePaymentGateway = new PurchasePaymentGateway();
                        $PurchasePaymentGateway->gateway_id = $id;
                        $PurchasePaymentGateway->gateway_name = $gateway_name;
                        $PurchasePaymentGateway->credentials = $credentials_array;
                        $PurchasePaymentGateway->status = 'Active';
                        $PurchasePaymentGateway->save();
                        
                        
                    }elseif($gateway_name == 'RazorPay'){
                        
                        $this->validate($request,[
                            'razorpay_key'   => 'required',
                            'razorpay_secret_key'  => 'required',
                              
                        ]); 
                        
                         $credentials_array = array('razorpay_key'=>$request->input('razorpay_key'),'razorpay_secret_key'=>$request->input('razorpay_secret_key'));
                        
                        
                        $PurchasePaymentGateway = new PurchasePaymentGateway();
                        
                        $PurchasePaymentGateway->gateway_id = $id;
                        $PurchasePaymentGateway->gateway_name = $gateway_name;
                        $PurchasePaymentGateway->credentials = $credentials_array;
                        $PurchasePaymentGateway->status = 'Active';
                        $PurchasePaymentGateway->save();
                        
                        
                        
                    }elseif($gateway_name == 'PayuBiz'){
                        
                        $this->validate($request,[
                            'payubiz_merchant_id'   => 'required',
                            'payubiz_merchant_key'  => 'required',
                            'payubiz_merchant_salt' => 'required',
                              
                        ]); 
                        
                         $credentials_array = array('payubiz_merchant_id'=>$request->input('payubiz_merchant_id'),'payubiz_merchant_key'=>$request->input('payubiz_merchant_key'),'payubiz_merchant_salt'=>$request->input('payubiz_merchant_salt'));
                        
                        $PurchasePaymentGateway = new PurchasePaymentGateway();
                        $PurchasePaymentGateway->gateway_id = $id;
                        $PurchasePaymentGateway->gateway_name = $gateway_name;
                        $PurchasePaymentGateway->credentials = $credentials_array;
                        $PurchasePaymentGateway->status = 'Active';
                        $PurchasePaymentGateway->save();
                        
                    }elseif($gateway_name == 'PayuMoney'){
                        
                        $this->validate($request,[
                            'payumoney_merchant_id'   => 'required',
                            'payumoney_merchant_key'  => 'required',
                            'payumoney_merchant_salt' => 'required',
                              
                        ]); 
                        
                         $credentials_array = array('payumoney_merchant_id'=>$request->input('payumoney_merchant_id'),'payumoney_merchant_key'=>$request->input('payumoney_merchant_key'),'payumoney_merchant_salt'=>$request->input('payumoney_merchant_salt'));
                        
                        $PurchasePaymentGateway = new PurchasePaymentGateway();
                        $PurchasePaymentGateway->gateway_id = $id;
                        $PurchasePaymentGateway->gateway_name = $gateway_name;
                        $PurchasePaymentGateway->credentials = $credentials_array;
                        $PurchasePaymentGateway->status = 'Active';
                        $PurchasePaymentGateway->save();
                        
                    }elseif($gateway_name == 'PayPal'){
                        
                        $this->validate($request,[
                            'paypal_client_id'   => 'required',
                              
                        ]); 
                        
                         $credentials_array = array('paypal_client_id'=>$request->input('paypal_client_id'));
                        
                        $PurchasePaymentGateway =  new PurchasePaymentGateway();
                        $PurchasePaymentGateway->gateway_id = $id;
                        $PurchasePaymentGateway->gateway_name = $gateway_name;
                        $PurchasePaymentGateway->credentials = $credentials_array;
                        $PurchasePaymentGateway->status = 'Active';
                        $PurchasePaymentGateway->save();
                        
                    }
                    
                    return redirect('payment_options')->with(['success'=>'Security credentials added successfully.']);
                }
        }
    }
    
    
    
    public function EditgatewayDetails($id){
        $get_all_methods = PaymentOption::Where('status','Unblock')->Where('_id',$id)->get();
        if($get_all_methods->isEmpty()){
             return redirect('payment_options');
        }else{
         
                foreach($get_all_methods as $data){
                    $gateway_name = $data->gateway;
                }
        
             $get_purchased_gateways = PurchasePaymentGateway::Where('gateway_id',$id)->get();
        
            if($get_purchased_gateways->isEmpty()){
                $get_purchased_gateways = array();
            }
            
             $features = $this->getfeatures();
    
            if(empty($features)){
    
               return redirect('MyDashboard')->with( 'error', "Something went wrong");
    
            }
            else{
                 return view('templates.myadmin.EditgatewayDetails')->with(['all_payment_methods'=>$get_all_methods,'gateway_name'=>$gateway_name,'get_purchased_gateways'=>$get_purchased_gateways,'allfeatures'=> $features]);
            }
        }
    }
    
    
    
         
    public function updateGatewayDetails(Request $request){
        

        if($request->input('id') == ''){
             return redirect('payment_options')->with(['error'=>'Something went wrong']);
        }else{
            
            
            // search auto id through gateway id
            
            $get_auto_id = PurchasePaymentGateway::Where('gateway_id', $request->input('id'))->get();
            if($get_auto_id->isNotEmpty()){
                foreach($get_auto_id as $gdata){
                    $auto_id = $gdata->id;
                }
            }else{
                 return redirect('payment_options')->with(['error'=>'Something went wrong']);
            }
            // gateway id
            $id = $request->input('id');
             $get_all_methods = PaymentOption::Where('status','Unblock')->Where('_id',$id)->get();
             
                if($get_all_methods->isEmpty()){
                     return redirect('payment_options');
                }else{
                 
                    foreach($get_all_methods as $data){
                        $gateway_name = $data->gateway;
                    }
                    
                    
                    if($gateway_name == 'Paytm'){
                        
                        $this->validate($request,[
                            'paytm_merchant_id'   => 'required',
                            'paytm_merchant_key'  => 'required',
                            'paytm_merchant_website' => 'required',
                            'industry_type_id'   => 'required',
                              
                        ]); 
                        $credentials_array = array('paytm_merchant_id'=>$request->input('paytm_merchant_id'),'paytm_merchant_key'=>$request->input('paytm_merchant_key'),'paytm_merchant_website'=>$request->input('paytm_merchant_website'),'industry_type_id'=>$request->input('industry_type_id'));
                        
                        $PurchasePaymentGateway = PurchasePaymentGateway::find($auto_id);
                        // $PurchasePaymentGateway->gateway_id = $id;
                        // $PurchasePaymentGateway->gateway_name = $gateway_name;
                        $PurchasePaymentGateway->credentials = $credentials_array;
                        $PurchasePaymentGateway->status = $request->input('status');
                        $PurchasePaymentGateway->save();
                        
                        
                    }elseif($gateway_name == 'RazorPay'){
                        
                        $this->validate($request,[
                            'razorpay_key'   => 'required',
                            'razorpay_secret_key'  => 'required',
                              
                        ]); 
                        
                         $credentials_array = array('razorpay_key'=>$request->input('razorpay_key'),'razorpay_secret_key'=>$request->input('razorpay_secret_key'));
                        
                        
                        $PurchasePaymentGateway = PurchasePaymentGateway::find($auto_id);
                        
                        // $PurchasePaymentGateway->vendor_auto_id = $vid;
                        // $PurchasePaymentGateway->gateway_id = $id;
                        // $PurchasePaymentGateway->gateway_name = $gateway_name;
                        $PurchasePaymentGateway->credentials = $credentials_array;
                        $PurchasePaymentGateway->status = $request->input('status');
                        $PurchasePaymentGateway->save();
                        
                        
                        
                    }elseif($gateway_name == 'PayuBiz'){
                        
                        $this->validate($request,[
                            'payubiz_merchant_id'   => 'required',
                            'payubiz_merchant_key'  => 'required',
                            'payubiz_merchant_salt' => 'required',
                              
                        ]); 
                        
                         $credentials_array = array('payubiz_merchant_id'=>$request->input('payubiz_merchant_id'),'payubiz_merchant_key'=>$request->input('payubiz_merchant_key'),'payubiz_merchant_salt'=>$request->input('payubiz_merchant_salt'));
                        
                        $PurchasePaymentGateway = PurchasePaymentGateway::find($auto_id);
                        //  $PurchasePaymentGateway->vendor_auto_id = $vid;
                        // $PurchasePaymentGateway->gateway_id = $id;
                        // $PurchasePaymentGateway->gateway_name = $gateway_name;
                        $PurchasePaymentGateway->credentials = $credentials_array;
                        $PurchasePaymentGateway->status = $request->input('status');
                        $PurchasePaymentGateway->save();
                        
                    }elseif($gateway_name == 'PayuMoney'){
                        
                        $this->validate($request,[
                            'payumoney_merchant_id'   => 'required',
                            'payumoney_merchant_key'  => 'required',
                            'payumoney_merchant_salt' => 'required',
                              
                        ]); 
                        
                         $credentials_array = array('payumoney_merchant_id'=>$request->input('payumoney_merchant_id'),'payumoney_merchant_key'=>$request->input('payumoney_merchant_key'),'payumoney_merchant_salt'=>$request->input('payumoney_merchant_salt'));
                        
                        $PurchasePaymentGateway = PurchasePaymentGateway::find($auto_id);
                        //  $PurchasePaymentGateway->vendor_auto_id = $vid;
                        // $PurchasePaymentGateway->gateway_id = $id;
                        // $PurchasePaymentGateway->gateway_name = $gateway_name;
                        $PurchasePaymentGateway->credentials = $credentials_array;
                        $PurchasePaymentGateway->status = $request->input('status');
                        $PurchasePaymentGateway->save();
                        
                    }elseif($gateway_name == 'PayPal'){
                        
                        $this->validate($request,[
                            'paypal_client_id'   => 'required',
                              
                        ]); 
                        
                         $credentials_array = array('paypal_client_id'=>$request->input('paypal_client_id'));
                        
                        $PurchasePaymentGateway = PurchasePaymentGateway::find($auto_id);
                        //  $PurchasePaymentGateway->vendor_auto_id = $vid;
                        // $PurchasePaymentGateway->gateway_id = $id;
                        // $PurchasePaymentGateway->gateway_name = $gateway_name;
                        $PurchasePaymentGateway->credentials = $credentials_array;
                        $PurchasePaymentGateway->status = $request->input('status');
                        $PurchasePaymentGateway->save();
                        
                    }
                    
                    
                    return redirect('payment_options')->with(['success'=>'Security credentials updated successfully.']);
                }
        }
    }
    
}