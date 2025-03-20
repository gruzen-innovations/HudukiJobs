<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserRegister;
use  App\Employee;
use App\Jobs;
use DB;
use Session;
use App\Traits\Features;

class WholeSalerController extends Controller
{
    use Features;

    public function index(){
      
           $wholesaler = UserRegister::where('Register_as','=','Employer')->get();
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
    	return view('templates.myadmin.user')->with(['customers' => $wholesaler, 'allfeatures' => $features]);
    }
}
 
 	public function edit($id){
    	$wholesaler = UserRegister::where('_id','=',$id)->where('Register_as','=','Employer')->get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
    	return view('templates.myadmin.edit_user')->with(['wholesalers' => $wholesaler, 'allfeatures' => $features]);
    }
}
	public function view_posted_jobs_list($id){
    	$jobs = Jobs::where('employer_auto_id','=',$id)->where('active_status','=','Active')->get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
    	return view('templates.myadmin.view_posted_jobs')->with(['jobs' => $jobs, 'allfeatures' => $features]);
    }
}

    public function update(Request $request){
    	$wholesaler = UserRegister::find($request->input('id'));
    	$wholesaler->status = $request->input('status');
    	$wholesaler->save();
    	return redirect('wholesalers')->with('success','Updated Successfully');
    }   
        public function index_employee(){
      
           $wholesaler = UserRegister::where('Register_as','=','Employee')->get();
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
    	return view('templates.myadmin.employee')->with(['customers' => $wholesaler, 'allfeatures' => $features]);
    }
}
 
 	public function edit_employee($id){
    	$wholesalers = UserRegister::where('_id','=',$id)->where('Register_as','=','Employee')->get();
    	$emp = Employee::where('employee_auto_id','=',$id)->get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
    	return view('templates.myadmin.edit_employee')->with(['wholesalers' => $wholesalers,'emp_details' => $emp, 'allfeatures' => $features]);
    }
}

    public function update_employee(Request $request){
    	$employee = UserRegister::find($request->input('id'));
    	$employee->status = $request->input('status');
    	$employee->save();
    	return redirect('employee')->with('success','Updated Successfully');
    }   
}
