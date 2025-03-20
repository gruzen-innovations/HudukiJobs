<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications;
use App\WholeSaler;
use App\UserRegister;
use App\NotificationCustomer;
use Session;
use DB;
use File;
use App\Traits\Features;

class NotificationsController extends Controller
{
    use Features;

    public function index(){
      
        $notifications = Notifications::get();
        if(count($notifications) == 0){
            $notifications = array();
        }
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        return view('templates.myadmin.notifications')->with(['notifications' => $notifications, 'allfeatures' => $features]);
    }
}
    public function show()
    {
      
       $getnotification = Notifications::get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
         return view('templates.myadmin.add_notification')->with(['notifications' => $getnotification,'allfeatures'=> $features]);
       }
       
    }

    public function store(Request $request){
        $this->validate(
          $request, 
          [   
           
            'title' => 'required',
            'message' => 'required',
        ],
        [   
            'title.required' => 'add title name',
            'message.required' => 'Enter Message',
        ]
    );
        
                // save notifications

                $notification = new Notifications();
                $notification->title = $request->input('title');
                $notification->message = $request->input('message');
                $notification->rdate = date('Y-m-d');
               
                $notification->save();

             // **************send notification*************** 

        $firebaseToken = UserRegister::where('Register_as','=','Employer')->whereNotNull('token')->pluck('token')->all();
        $SERVER_API_KEY = 'AAAAuOo7Z30:APA91bFef9863oqsNOEjbvplMsJ4QKAo5NSfz9hgjtJ1YXOTRj5LCqJU8-ddFX-28JSf7RGmD62M5gTtaNwyMEGLtQCmo-Jx2JMDmXZH3LjqyymMiI0iqzVpz_hLdnMW1OLjHMnBLxBz';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
            "body"  =>  $request->input('message'),
            "title" => $request->input('title'),
            "sound" => "default",
            "click_action" => "com.jobportal.jobportal.job_portal",  
            ]

        ];

        $dataString = json_encode($data);
        $headers = [

            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',

        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        
         $response = curl_exec($ch);
        
         return redirect('notifications')->with('success', 'Added Successfully');
    }


  public function delete($id)
  {
       $notification = Notifications::find($id);
       $notification->delete();
       return redirect('notifications')->with('success', 'Deleted Successfully');
   }
   
   public function show_edit($id){
        $ndatas = Notifications::Where('_id',$id)->get();
        if($ndatas->isEmpty()){
            return redirect('notifications');
        }else{
            foreach($ndatas as $data){
                $ndays = $data->show_notification_days;
            }
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        return view('templates.myadmin.edit-notification')->with(['ndays' => $ndays,'nid'=>$id, 'allfeatures' => $features]);
     }
        }
    }
    
    public function update(Request $request){
         $this->validate(
          $request, 
            [   
                'show_notification_days' => 'required'
            ],
            [   
                'show_notification_days.required' => 'Enter number of days'
            ]
        );
            // save notifications
                $id=$request->input('nid');
                $notification = Notifications::find($id);
                $notification->show_notification_days = $request->input('show_notification_days');
                $notification->save();
                
                 return redirect('notifications')->with('success', 'Updated Successfully');
    }
   
   
}




