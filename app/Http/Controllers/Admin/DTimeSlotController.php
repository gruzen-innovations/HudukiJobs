<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DTimeSlot;
use Session;
use DB;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;

class DTimeSlotController extends Controller
{
    use Features;
    use VendorPaidOrder;
    public function index(){
      
      $timeslot = DTimeSlot::ORDERBY('_id','DESC')->get();
      $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }else{
          return view('templates.myadmin.delivery_timeslot')->with(['timeslots'=> $timeslot,'allfeatures' => $features]);
      }
    }
     public function show()
    {
        
       $timeslot = DTimeSlot::get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        return view('templates.myadmin.add_delivery_timeslot')->with(['timeslots' => $timeslot,'allfeatures' => $features]);
       }
    }
    public function store(Request $request){
    	$this->validate(
          $request, 
          [   
           
            'start_time' => 'required',
            'end_time' => 'required',
         ],
           [   
           
            'start_time.required' => 'Enter start time',
            'end_time.required' => 'Enter end time',
           ]
      );
       
        
        $dtimeslot = new DTimeSlot();
        $dtimeslot->start_time= $request->get('start_time');
        $dtimeslot->end_time= $request->get('end_time');
        $dtimeslot->save();
        return redirect('delivery-time')->with('success', 'Added Successfully');
    }

    public function edit($id)
    {
        $timeslot = DTimeSlot::where('_id','=',$id)->get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
           return view('templates.myadmin.edit_delivery_timeslot')->with(['timeslots'=> $timeslot,'allfeatures' => $features]);
        }
    }

    public function update(Request $request){
     
        $this->validate(
          $request, 
          [   
          
            'start_time' => 'required',
            'end_time' => 'required',
            
          ],
          [   
           
            'start_time.required' => 'Enter start time',
            'end_time.required' => 'Enter end time',
            
          ]
       );
        
                
      
        $timeslot = DTimeSlot::find($request->get('id'));
        $timeslot->start_time= $request->get('start_time');
        $timeslot->end_time= $request->get('end_time');
        $timeslot->save();
        return redirect('delivery-time')->with('success','Updated Successfully');
    }
    public function delete($id)
   {
        $timeslot = DTimeSlot::find($id);
        $timeslot->delete();
       return redirect('delivery-time')->with('success', 'Deleted Successfully');
  }


}

