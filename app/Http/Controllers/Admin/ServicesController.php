<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services;
use Session;
use File;
use App\Traits\VendorPaidOrder;

class ServicesController extends Controller
{
use Features;
use VendorPaidOrder;
public function index()
   {
    
           $services = Services::where('vendor_auto_id','=',$vid)->get();
    
          $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        return view('templates.myadmin.services')->with(['services'=>$services,'allfeatures' => $features]);
        }
  }
    public function show(){
        
        $service = Services::get();
        
         $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        return view('templates.myadmin.add_services')->with(['services'=>$service, 'allfeatures' => $features]);
         }
    }

    public function store(Request $request)
  {
     $this->validate(
         $request,
           [  
             'sname' =>'required',
             'description' =>'required',
            
           ],
           [  
             'sname.required' =>'add services name',
             'description.required' =>'add description',
           
      ]
       );

 
     $services = new  Services();

     $services->sname = $request->input('sname');
     $services->description = $request->input('description');
     $services->save();

     return redirect('services')->with('success', 'Added Successfully');
     }




 public function edit($id)
   {
     $services = Services::where('_id','=',$id)->get();
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
     return view('templates.myadmin.edit_services')->with(['services' => $services,'allfeatures' => $features]);
    }
   }

   public function update(Request $request)
     {
     
         $this->validate(
          $request, 
            [   
                'sname' => 'required',
                'description' =>'required',
            ],
            [   
                'sname.required' => 'Add services name',
                'description.required' =>'add description',
            ]
        );
        
         $Services = Services::find($request->get('id'));
         $Services->sname = $request->input('sname');
         $Services->description = $request->input('description');
         $Services->save();
       return redirect('services')->with('success','Updated Successfully');
     }
public function delete($id)
  {
       $services = Services::find($id);
       $services->delete();
       return redirect('services')->with('success', 'Deleted Successfully');
   }
  }      