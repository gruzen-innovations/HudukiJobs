<?php
namespace App\Traits;
use App\UserCount;
use Session;
trait CustomerRegistrationCount
{
	public function getcustomer_count($vid)
    {
		
		 // **************User Count*************** 
            	        
            // user(customer) limit
                $get_userlimit = UserCount::WHERE('vendor_auto_id',$vid)->Where('purchase_status','Active')->Where('status','Active')->Where('main_category_id','MCAT01')->get();
            	       
            	       
               if($get_userlimit->isNotEmpty())
               {
            	    foreach($get_userlimit as $datan)
            	      {
            	        $user_limit = $datan['user_limit'];
            	        $used_user = $datan['used_user'];
            	        $user_purchase_id = $datan['id'];
            	      }
            	           
            	       //check user remaining or not
            	       if($used_user <= $user_limit)
            	       {
                            $permission = array("SAVE_USER");
                            
                            //update user count
            	               
            	               $latest_used = $used_user + 1;
            	               
            	               if($latest_used == $user_limit){
            	                     $customer_count = UserCount::find($user_purchase_id);
                	               $customer_count->used_user = $latest_used;
                	               $customer_count->status ='Deactive';
                	               $customer_count->save();
            	               }else{
            	                    
                	               $customer_count = UserCount::find($user_purchase_id);
                	               $customer_count->used_user = $latest_used;
                	               $customer_count->save();
            	               }
            	           
                            
            	            return $permission;
            	        
            	       }else{
            	           $permission = array();
            	           return $permission;
            	       }
             }
	}
}
