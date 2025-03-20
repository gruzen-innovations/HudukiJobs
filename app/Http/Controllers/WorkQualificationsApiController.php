<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\userQualificationsDetails;
use App\userWorkDetails;

use DateTime;
use DB;

class WorkQualificationsApiController extends Controller
{
 //work details
      public function add_employee_work_details(Request $request){
       
            $emp = new userWorkDetails();
            $emp->employee_auto_id = $request->get('employee_auto_id');
  
                if($request->get('company_name')!=''){
                        $emp->company_name = $request->get('company_name');
                }else{
                        $emp->company_name ="";
                }       
                if($request->get('designation')!=''){
                        $emp->designation = $request->get('designation');
                }else{
                        $emp->designation ="";
                }   
                if($request->get('work_from')!=''){
                        $emp->work_from = $request->get('work_from');
                }else{
                        $emp->work_from ="";
                }       
                if($request->get('project_count')!=''){
                        $emp->project_count = $request->get('project_count');
                }else{
                        $emp->project_count ="";
                }   
                if($request->get('total_year_experience')!=''){
                        $emp->total_year_experience = $request->get('total_year_experience');
                }else{
                        $emp->total_year_experience ="";
                }       
                if($request->get('description_of_project')!=''){
                        $emp->description_of_project = $request->get('description_of_project');
                }else{
                        $emp->description_of_project ="";
                }   
                
                $emp->save();
            
             return response()->json([
                'status' => 1, 
                'msg' => "Added Successfully",
            ]);

    }
           // Update Profile
    public function edit_employee_work_details(Request $request){
        $bdetails = userWorkDetails::where('employee_auto_id', $request->employee_auto_id)->where('_id','=',$request->work_details_auto_id)->get();
        if($bdetails->isNotEmpty()){
        $emps = userWorkDetails::find($request->get('work_details_auto_id'));
        if(empty($emps)){
            return response()->json(['status' => 0, "msg" => "No job Found"]);
        }
        else{
                if($request->get('company_name')!=''){
                        $emps->company_name = $request->get('company_name');
                } 
                if($request->get('designation')!=''){
                        $emps->designation = $request->get('designation');
                }      
                if($request->get('work_from')!=''){
                        $emps->work_from = $request->get('work_from');
                }   
                if($request->get('project_count')!=''){
                        $emps->project_count = $request->get('project_count');
                } 
                if($request->get('total_year_experience')!=''){
                        $emps->total_year_experience = $request->get('total_year_experience');
                }     
                if($request->get('description_of_project')!=''){
                        $emps->description_of_project = $request->get('description_of_project');
                } 
                
                $emps->save();         
           
            return response()->json(['status' => 1, "msg" => config('messages.success'), 'data' => $emps]);
        }
    }else{
        return response()->json([
                'status' => 0, 
                'msg' => 'Someting went wrong',
            ]);
    }
    }
        //delete work details
      public function delete_employee_work_details(Request $request){
        $tdetailss = userWorkDetails::where('employee_auto_id', $request->employee_auto_id)->where('_id','=',$request->work_details_auto_id)->get();
         if($tdetailss){
                  $tdetlss = userWorkDetails::find($request->work_details_auto_id);
                  $tdetlss->delete();
                  
            return response()->json([
                'status' => 1, 
                'msg' => "Sucessfully Deleted"
            ]);
        }else{
           
            return response()->json([
                'status' => 0, 
                'msg' => "Something went wrong"
            ]);
        }
   }
   //add_employee_qualification_details
      public function add_employee_qualification_details(Request $request){
       
            $emp = new userQualificationsDetails();
            $emp->employee_auto_id = $request->get('employee_auto_id');
                if($request->get('highest_qualification')!=''){
                        $emp->highest_qualification = $request->get('highest_qualification');
                }else{
                        $emp->highest_qualification ="";
                }   
                if($request->get('course')!=''){
                        $emp->course = $request->get('course');
                }else{
                        $emp->course ="";
                }       
                if($request->get('university')!=''){
                        $emp->university = $request->get('university');
                }else{
                        $emp->university ="";
                }   
                if($request->get('year_of_completion')!=''){
                        $emp->year_of_completion = $request->get('year_of_completion');
                }else{
                        $emp->year_of_completion ="";
                }       
                if($request->get('marks_or_percentage')!=''){
                        $emp->marks_or_percentage = $request->get('marks_or_percentage');
                }else{
                        $emp->marks_or_percentage ="";
                }   
                $emp->save();
            
             return response()->json([
                'status' => 1, 
                'msg' => "Added Successfully",
            ]);

    }
           // edit_employee_qualification_details
    public function edit_employee_qualification_details(Request $request){
        $bdetails = userQualificationsDetails::where('employee_auto_id', $request->employee_auto_id)->where('_id','=',$request->qualification_details_auto_id)->get();
        if($bdetails->isNotEmpty()){
        $emps = userQualificationsDetails::find($request->get('qualification_details_auto_id'));
        if(empty($emps)){
            return response()->json(['status' => 0, "msg" => "No job Found"]);
        }
        else{
                if($request->get('highest_qualification')!=''){
                        $emps->highest_qualification = $request->get('highest_qualification');
                } 
                if($request->get('course')!=''){
                        $emps->course = $request->get('course');
                }      
                if($request->get('university')!=''){
                        $emps->university = $request->get('university');
                }   
                if($request->get('year_of_completion')!=''){
                        $emps->year_of_completion = $request->get('year_of_completion');
                }       
                if($request->get('marks_or_percentage')!=''){
                        $emps->marks_or_percentage = $request->get('marks_or_percentage');
                } 
                $emps->save();         
           
            return response()->json(['status' => 1, "msg" => config('messages.success'), 'data' => $emps]);
        }
    }else{
        return response()->json([
                'status' => 0, 
                'msg' => 'Someting went wrong',
            ]);
    }
    }
        //delete_employee_qualification_details
      public function delete_employee_qualification_details(Request $request){
        $tdetailss = userQualificationsDetails::where('employee_auto_id', $request->employee_auto_id)->where('_id','=', $request->qualification_details_auto_id)->get();
         if($tdetailss){
                  $tdetlss = userQualificationsDetails::find($request->qualification_details_auto_id);
                  $tdetlss->delete();
                  
            return response()->json([
                'status' => 1, 
                'msg' => "Sucessfully Deleted"
            ]);
        }else{
           
            return response()->json([
                'status' => 0, 
                'msg' => "Something went wrong"
            ]);
        }
   }

}