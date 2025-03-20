<?php
namespace App\Traits;
use App\NotificationCount;
use Session;
trait CustomerNotification
{
	public function getnotificaton_count($vid)
    {
		
		 // **************notification*************** 
            	        
            // notification limit
                $get_notification = NotificationCount::WHERE('vendor_auto_id',$vid)->Where('purchase_status','Active')->Where('status','Active')->Where('main_category_id','MCAT01')->get();
            	       
            	       
               if($get_notification->isNotEmpty())
               {
            	    foreach($get_notification as $datan)
            	      {
            	        $notification_limit = $datan['notification_limit'];
            	        $used_notification = $datan['used_notification'];
            	        $notification_purchase_id = $datan['id'];
            	      }
            	           
            	       //check notification remaining or not
            	       if($notification_limit != $used_notification)
            	       {
                            $permission = array("SEND_NOTIFICATION");
                            
                            //update notification count
            	               
            	               $latest_used = $used_notification + 1;
            	               
            	               if($latest_used == $notification_limit){
            	                     $notification_count = NotificationCount::find($notification_purchase_id);
                	               $notification_count->used_notification = $latest_used;
                	               $notification_count->status = 'Deactive';
                	               $notification_count->save();
            	               }else{
            	                    
                	               $notification_count = NotificationCount::find($notification_purchase_id);
                	               $notification_count->used_notification = $latest_used;
                	               $notification_count->save();
            	               }
            	           
                            
            	            return $permission;
            	        
            	       }else{
            	           $permission = array();
            	           return $permission;
            	       }
             }
	}
}
