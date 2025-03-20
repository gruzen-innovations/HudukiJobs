<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Unit;
use Session;
use DB;
use File;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;

class UnitController extends Controller
{
    use Features;
    use VendorPaidOrder;
    public function index(){
    
       $unit = Unit::get();
    
      $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        // $features = array();
    	return view('templates.myadmin.unit')->with(['units'=> $unit,'allfeatures' => $features]);
    }
    }
     public function add()
    {
      
           $unit = Unit::get();
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        // $features = array();
        return view('templates.myadmin.add_unit')->with(['units' => $unit,'allfeatures' => $features]);
    }
  }
    public function store(Request $request){
    	$this->validate(
          $request, 
          [   
            'unit' => 'required',
           
        ],
        [   
            'unit.required' => 'Enter Product unit',
            
        ]
    );
        $vid = Session::get('AccessToken');
        $unit = new Unit();
        
        $unit->unit= $request->input('unit');
      $unit->save();
        return redirect('unit')->with('success', 'Added Successfully');
    }

    public function delete($id)
  {
    
      $unit = Unit::find($id);
       $unit->delete();
      return redirect('unit')->with('success', 'Deleted Successfully');
    }


}

