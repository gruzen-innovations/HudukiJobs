<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SaveJobs;
use App\Jobs;
use App\BookmartCandidate;
use DateTimeZone;
use App\Professions;
use App\WorkingWith;
use App\Qualifications;
use App\Height;
use App\UserRegister;
use App\AppliedJobs;
use App\Employee;
use App\userQualificationsDetails;
use App\userWorkDetails;
use App\RecruiterAction;
use App\FollowCompany;
use App\RateEmployee;
use DateTime;
use DB;

class JobApiController extends Controller
{
    //bookmark candidate
    public function bookmark_candidate(Request $request)
    {

        $checkproduct = BookmartCandidate::where('employer_auto_id', $request->employer_auto_id)->where('candidate_auto_id', $request->candidate_auto_id)->first();
        if ($checkproduct) {
            DB::table('bookmark_candidates')->where('employer_auto_id', $request->employer_auto_id)->where('candidate_auto_id', $request->candidate_auto_id)->where('is_bookmark', 'No')->update(['is_bookmark' => 'Yes']);
            return response()->json([
                'status' => '1',
                'msg' => 'Added to Bookmart !',
                'data' => $checkproduct
            ]);
        } else {
            $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
            $rdate =  $date->format('Y-m-d');

            $productcart = new BookmartCandidate();
            $productcart->employer_auto_id = $request->get('employer_auto_id');
            $productcart->candidate_auto_id = $request->get('candidate_auto_id');
            $productcart->is_bookmark = 'Yes';
            $productcart->rdate = date('Y-m-d');
            $productcart->save();

            return response()->json([
                'status' => '1',
                'msg' => 'Added to Bookmart !',
                'data' => $productcart
            ]);
        }
    }
    //Delete bookmarked candidate
    public function delete_bookmark_candidate(Request $request)
    {

        $idetails = BookmartCandidate::where('candidate_auto_id', '=', $request->get('candidate_auto_id'))->where('employer_auto_id', '=', $request->get('employer_auto_id'))->update(['is_bookmark' => 'No']);

        if ($idetails) {
            return response()->json([
                'status' => 1,
                'msg' => "Sucessfully Deleted"
            ]);
        } else {

            return response()->json([

                'status' => 0,
                'msg' => "someting went wrong"

            ]);
        }
    }
    //cart added products
    public function get_bookmark_candidate(Request $request)
    {

        $cprds = BookmartCandidate::where('employer_auto_id', '=', $request->get('employer_auto_id'))->where('is_bookmark', '=', 'Yes')->get();
        if ($cprds->isEmpty()) {
            return response()->json([
                'status' => 0,
                "msg" => "No Data Available"
            ]);
        } else {

            foreach ($cprds as $curs) {
                $pcat = UserRegister::where('_id', '=', $curs->candidate_auto_id)->where('Register_as', '=', 'Employee')->get();
                if ($pcat->isNotEmpty()) {
                    foreach ($pcat as $uts) {
                        $edata = Employee::where('employee_auto_id', '=', $curs->candidate_auto_id)->get();
                        unset($atdetails);
                        if ($edata->isNotEmpty()) {
                            foreach ($edata as $at) {
                                //qualification details
                                unset($quadetails);
                                $qdetailss = userQualificationsDetails::where('employee_auto_id', '=', $at->employee_auto_id)->get();
                                if ($qdetailss->isNotEmpty()) {
                                    foreach ($qdetailss as $qdata) {
                                        $quadetails[] = array("qualification_details_auto_id" => $qdata->_id, "highest_qualification" => $qdata->highest_qualification, "course" => $qdata->course, "university" => $qdata->university, "year_of_completion" => $qdata->year_of_completion, "marks_or_percentage" => $qdata->marks_or_percentage);
                                    }
                                } else {
                                    $quadetails = array();
                                }
                                //work experience
                                unset($wfdetails);
                                $wdetailss = userWorkDetails::where('employee_auto_id', '=', $at->employee_auto_id)->get();
                                if ($wdetailss->isNotEmpty()) {
                                    foreach ($wdetailss as $wdata) {
                                        $wfdetails[] = array("work_details_auto_id" => $wdata->_id, "company_name" => $wdata->company_name, "designation" => $wdata->designation, "work_from" => $wdata->work_from, "project_count" => $wdata->project_count, "total_year_experience" => $wdata->total_year_experience, "description_of_project" => $wdata->description_of_project);
                                    }
                                } else {
                                    $wfdetails = array();
                                }
                                $ratings = RateEmployee::where('employee_auto_id', $at->employee_auto_id)->get();
                                $averageRating = $ratings->isNotEmpty() ? $ratings->avg('rate') : null;

                                $atdetails[] = array(
                                    "resume" => $at->resume,
                                    "video_resume" => $at->video_resume,
                                    "profile_picture" => $at->profile_picture,
                                    "first_name" => $at->first_name,
                                    "middle_name" => $at->middle_name,
                                    "last_name" => $at->last_name,
                                    "gender" => $at->gender,
                                    "date_of_birth" => $at->date_of_birth,
                                    "address" => $at->address,
                                    "city" => $at->city,
                                    "pincode" => $at->pincode,
                                    "fresher_or_experienced" => $at->fresher_or_experienced,
                                    "skills" => $at->skills,
                                    "prefered_jobrole" => $at->prefered_jobrole,
                                    "prefered_job_locaion" => $at->prefered_job_locaion,
                                    "field_of_experience" => $at->field_of_experience,
                                    "total_year_experience" => $at->total_year_experience,
                                    "employment_type" => $at->employment_type,
                                    "description_of_project" => $at->description_of_project,
                                    "advance_skills" => $at->advance_skills,
                                    "preferred_job_type" => $at->preferred_job_type,
                                    "preferred_shift" => $at->preferred_shift,
                                    "current_ctc" => $at->current_ctc,
                                    "expected_ctc" => $at->expected_ctc,
                                    "open_to_work" => $at->open_to_work,
                                    "adhaar_card_img_front" => $at->adhaar_card_img_front,
                                    "adhaar_card_img_back" => $at->adhaar_card_img_back,
                                    "last_seen_datetime" => $at->last_seen_datetime,
                                    "average_rating" => $averageRating,
                                    "Qualifications_data" => $quadetails,
                                    "work_details_data" => $wfdetails,

                                );
                            }
                        } else {
                            $atdetails = array();
                        }
                        $atdatewisetdetails[] = array(
                            "employee_auto_id" => $uts->_id,
                            "name" => $uts->name,
                            "email_id" => $uts->email_id,
                            "mobile_number" => $uts->mobile_number,
                            "status" => $uts->status,
                            "Register_as" => $uts->Register_as,
                            "profile_photo" => $uts->profile_photo,
                            "register_date" => $uts->register_date,
                            "is_bookmark" => 'Yes',
                            "other_details" => $atdetails
                        );
                    }
                } else {
                    $atdatewisetdetails = array();
                }
            }
            return response()->json([
                'status' => 1,
                'data' => $atdatewisetdetails,
            ]);
        }
    }
    //save jobs
    public function save_jobs(Request $request)
    {

        $checkproduct = SaveJobs::where('employee_auto_id', $request->employee_auto_id)->where('job_auto_id', $request->job_auto_id)->first();
        if ($checkproduct) {
            // if($checkproduct->is_save_job == 'No'){
            DB::table('save_jobs')->where('employee_auto_id', $request->employee_auto_id)->where('job_auto_id', $request->job_auto_id)->where('is_save_job', 'No')->update(['is_save_job' => 'Yes']);
            // }else{
            //   DB::table('save_jobs')->where('employee_auto_id', $request->employee_auto_id)->where('job_auto_id', $request->job_auto_id)->where('is_save_job', 'Yes')->update(['is_save_job' => 'No']);

            // }
            return response()->json([
                'status' => '1',
                'msg' => 'Saved Job !',
                'data' => $checkproduct
            ]);
        } else {
            $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
            $rdate =  $date->format('Y-m-d');
            $jobs = new SaveJobs();
            $jobs->job_auto_id = $request->get('job_auto_id');
            $jobs->employee_auto_id = $request->get('employee_auto_id');
            $jobs->is_save_job = 'Yes';
            $jobs->rdate = date('Y-m-d');
            $jobs->save();

            return response()->json([
                'status' => '1',
                'msg' => 'Saved Job !',
                'data' => $jobs

            ]);
        }
    }
    //Delete saved jobs
    public function delete_save_jobs(Request $request)
    {

        $idetails = SaveJobs::where('employee_auto_id', $request->employee_auto_id)->where('job_auto_id', $request->job_auto_id)->update(['is_save_job' => 'No']);

        if ($idetails) {
            return response()->json([
                'status' => 1,
                'msg' => "Sucessfully Deleted"
            ]);
        } else {

            return response()->json([
                'status' => 0,
                'msg' => "someting went wrong"
            ]);
        }
    }
    //saved job list
    public function get_save_jobs(Request $request)
    {

        $cprds = SaveJobs::where('employee_auto_id', '=', $request->get('employee_auto_id'))->where('is_save_job', '=', 'Yes')->get();
        if ($cprds->isEmpty()) {
            return response()->json([
                'status' => 0,
                "msg" => "No Data Available"
            ]);
        } else {

            foreach ($cprds as $curs) {
                $pcat = Jobs::where('_id', '=', $curs->job_auto_id)->get();
                if ($pcat->isNotEmpty()) {
                    foreach ($pcat as $uts) {
                        $emp_details = UserRegister::where('_id', '=', $uts->employer_auto_id)->where('Register_as', '=', 'Employer')->get();
                        $follower = FollowCompany::where('employee_auto_id', $request->get('employee_auto_id'))
                            ->where('follow_id', $uts->employer_auto_id)
                            ->first();
                        $atdatewisetdetails[] = array(
                            "save_job_auto_id" => $curs->_id,
                            "is_save_job" => $curs->is_save_job,
                            "job_auto_id" => $uts->_id,
                            "employer_auto_id" => $uts->employer_auto_id,
                            "job_role" => $uts->job_role,
                            "job_type" => $uts->job_type,
                            "job_location" => $uts->job_location,
                            "required_qualification" => $uts->required_qualification,
                            "min_salary" => $uts->min_salary,
                            "max_salary" => $uts->max_salary,
                            "hide_salary" => $uts->hide_salary,
                            "hiring_process" => $uts->hiring_process,
                            "walkIn_Interview" => $uts->walkIn_Interview,
                            "job_option" => $uts->job_option,
                            "experience_from_years" => $uts->experience_from_years,
                            "experience_to_years" => $uts->experience_to_years,
                            "no_of_vacancies" => $uts->no_of_vacancies,
                            "year_of_passing_from" => $uts->year_of_passing_from,
                            "year_of_passing_to" => $uts->year_of_passing_to,
                            "skills" => $uts->skills,
                            "gender" => $uts->gender,
                            "percent" => $uts->percent,
                            "cgpa" => $uts->cgpa,
                            "job_description" => $uts->job_description,
                            "recruiter_email" => $uts->recruiter_email,
                            "recruiter_contact_no" => $uts->recruiter_contact_no,
                            "walkin_location" => $uts->walkin_location,
                            "walk_in_time" => $uts->walk_in_time,
                            "walk_in_date" => $uts->walk_in_date,
                            "incentives" => $uts->incentives,
                            "benefits" => $uts->benefits,
                            "allowances" => $uts->allowances,
                            'follow' => $follower->follow ??
                                'false',
                            "employer_details" => $emp_details
                        );
                    }
                } else {
                    $atdatewisetdetails = array();
                }
            }
            return response()->json([
                'status' => 1,
                'data' => $atdatewisetdetails,
            ]);
        }
    }
    //apply jobs
    public function apply_jobs(Request $request)
    {

        $checkproduct = AppliedJobs::where('employee_auto_id', $request->employee_auto_id)->where('job_auto_id', $request->job_auto_id)->first();
        if ($checkproduct) {
            return response()->json([
                'status' => '0',
                'msg' => 'You have alredy applied to this job !',
            ]);
        } else {
            $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
            $rdate =  $date->format('Y-m-d');
            $jobs = new AppliedJobs();
            $jobs->job_auto_id = $request->get('job_auto_id');
            $jobs->employee_auto_id = $request->get('employee_auto_id');
            $jobs->employer_auto_id = $request->get('employer_auto_id');
            $jobs->rdate = date('Y-m-d');
            $jobs->walk_in_date = $request->get('walk_in_date');
            $jobs->walk_in_time = $request->get('walk_in_time');
            $jobs->walkin_location = $request->get('walkin_location');

            $jobs->save();

            return response()->json([
                'status' => "1",
                'data' => $jobs
            ]);
        }
    }

    //applied job list
    public function get_applied_jobs(Request $request)
    {

        $cprds = AppliedJobs::where('employee_auto_id', '=', $request->get('employee_auto_id'))->get();
        if ($cprds->isEmpty()) {
            return response()->json([
                'status' => 0,
                "msg" => "No Data Available"
            ]);
        } else {

            foreach ($cprds as $curs) {
                $pcat = Jobs::where('_id', '=', $curs->job_auto_id)->get();
                if ($pcat->isNotEmpty()) {
                    foreach ($pcat as $uts) {
                        $emp_details = UserRegister::where('_id', '=', $uts->employer_auto_id)->where('Register_as', '=', 'Employer')->get();
                        $follower = FollowCompany::where('employee_auto_id', $request->employee_auto_id)
                            ->where('follow_id', $uts->employer_auto_id)
                            ->first();
                        $atdatewisetdetails[] = array(
                            "job_auto_id" => $uts->_id,
                            "employer_auto_id" => $uts->employer_auto_id,
                            "job_role" => $uts->job_role,
                            "job_type" => $uts->job_type,
                            "job_location" => $uts->job_location,
                            "required_qualification" => $uts->required_qualification,
                            "min_salary" => $uts->min_salary,
                            "max_salary" => $uts->max_salary,
                            "hide_salary" => $uts->hide_salary,
                            "hiring_process" => $uts->hiring_process,
                            "walkIn_Interview" => $uts->walkIn_Interview,
                            "job_option" => $uts->job_option,
                            "active_status" => $uts->active_status,
                            "experience_from_years" => $uts->experience_from_years,
                            "experience_to_years" => $uts->experience_to_years,
                            "no_of_vacancies" => $uts->no_of_vacancies,
                            "year_of_passing_from" => $uts->year_of_passing_from,
                            "year_of_passing_to" => $uts->year_of_passing_to,
                            "skills" => $uts->skills,
                            "gender" => $uts->gender,
                            "percent" => $uts->percent,
                            "cgpa" => $uts->cgpa,
                            "job_description" => $uts->job_description,
                            "recruiter_email" => $uts->recruiter_email,
                            "recruiter_contact_no" => $uts->recruiter_contact_no,
                            "walkin_location" => $uts->walkin_location,
                            "walk_in_time" => $uts->walk_in_time,
                            "walk_in_date" => $uts->walk_in_date,
                            "incentives" => $uts->incentives,
                            "benefits" => $uts->benefits,
                            "allowances" => $uts->allowances,
                            'follow' => $follower->follow ??
                                'false',
                            "employer_details" => $emp_details
                        );
                    }
                } else {
                    $atdatewisetdetails = array();
                }
            }
            return response()->json([
                'status' => 1,
                'data' => $atdatewisetdetails,
            ]);
        }
    }
    //employer employees
    public function get_all_candidateList(Request $request)
    {

        $cprds = AppliedJobs::where('employer_auto_id', '=', $request->get('employer_auto_id'))->get();
        if ($cprds->isEmpty()) {
            return response()->json([
                'status' => 0,
                "msg" => "No Data Available"
            ]);
        } else {
            foreach ($cprds->unique('employee_auto_id') as $curs) {
                // unset($atdatewisetdetailss);
                $pcats = UserRegister::where('_id', '=', $curs->employee_auto_id)->get();
                if ($pcats->isNotEmpty()) {
                    foreach ($pcats as $uts) {
                        unset($atdetailsss);
                        $edatass = Employee::where('employee_auto_id', '=', $uts->id)->get();
                        if ($edatass->isNotEmpty()) {
                            foreach ($edatass as $at) {
                                //qualification details
                                //     $pid = $at->highest_qualification;
                                //     $qid = $at->course;
                                //     $pqid = $at->university;
                                //     $wid = $at->year_of_completion;
                                //     $mid = $at->marks_or_percentage;
                                //     if($pid != '' && $qid != '' && $pqid != '' && $wid != '' && $mid != ''){
                                //          $input=$request->all();
                                //          $pids=array();
                                //          $qids=array();
                                //          $pqids=array();
                                //          $wids=array();
                                //          $mids=array();

                                //       $product_ids = explode(',',$pid);
                                //       $quantity_ids = explode(',',$qid);
                                //       $product_quantity_ids = explode(',',$pqid);
                                //       $unit_ids = explode(',',$wid);
                                //       $mark_ids = explode(',',$mid);
                                //       foreach($product_ids as $data1){
                                //             $pids[]=$data1;
                                //       }
                                //       foreach($quantity_ids as $data2){
                                //             $qids[]=$data2;
                                //       }
                                //       foreach($product_quantity_ids as $data4){
                                //             $pqids[]=$data4;
                                //       }
                                //       foreach($unit_ids as $data3){
                                //             $wids[]=$data3;
                                //       }
                                //       foreach($mark_ids as $data5){
                                //             $mids[]=$data5;
                                //       }

                                //                  $emailArray = $pids;
                                //     $totalEmails = count($emailArray);
                                //                      $qArray = $qids;
                                //     $totalquantities = count($qArray);
                                //                           $pqArray = $pqids;
                                //     $totalproductquantities = count($pqArray);
                                //                  $wArray = $wids;
                                //     $totalwights = count($wArray);
                                //                 $mArray = $mids;
                                //     $totalmarks = count($mArray);
                                //         for($i=0; $i<$totalEmails; $i++) {
                                //           $quadetails[] = array("highest_qualification"=>$emailArray[$i],"course"=>$qArray[$i],"university"=>$pqArray[$i],"year_of_completion"=>$wArray[$i],"marks_or_percentage"=>$mArray[$i]);
                                //         }
                                //     }else{
                                //          $quadetails = array();
                                //     }

                                //     $cid = $at->company_name;
                                //     $did = $at->designation;
                                //     $wfid = $at->work_from;
                                // if($cid != '' && $did != '' && $wfid != ''){
                                //          $input=$request->all();
                                //          $cids=array();
                                //          $dids=array();
                                //          $wfids=array();

                                //       $company_ids = explode(',',$cid);
                                //       $desig_ids = explode(',',$did);
                                //       $work_from_ids = explode(',',$wfid);

                                //       foreach($company_ids as $data1){
                                //             $cids[]=$data1;
                                //       }
                                //       foreach($desig_ids as $data2){
                                //             $dids[]=$data2;
                                //       }
                                //       foreach($work_from_ids as $data4){
                                //             $wfids[]=$data4;
                                //       }

                                //                  $companylArray = $cids;
                                //     $totalcompanys = count($companylArray);
                                //                      $dArray = $dids;
                                //     $totaldesigs = count($dArray);
                                //                           $wfArray = $wfids;
                                //     $totalwork_from = count($wfArray);

                                //     for($i=0; $i<$totalcompanys; $i++) {
                                //       $wfdetails[] = array("company_name"=>$companylArray[$i],"designation"=>$dArray[$i],"work_from"=>$wfArray[$i]);
                                //   }
                                // }else{
                                //      $wfdetails = array();
                                //  }
                                //qualification details
                                unset($quadetails);
                                $qdetailss = userQualificationsDetails::where('employee_auto_id', '=', $at->employee_auto_id)->get();
                                if ($qdetailss->isNotEmpty()) {
                                    foreach ($qdetailss as $qdata) {
                                        $quadetails[] = array("qualification_details_auto_id" => $qdata->_id, "highest_qualification" => $qdata->highest_qualification, "course" => $qdata->course, "university" => $qdata->university, "year_of_completion" => $qdata->year_of_completion, "marks_or_percentage" => $qdata->marks_or_percentage);
                                    }
                                } else {
                                    $quadetails = array();
                                }
                                //work experience
                                unset($wfdetails);
                                $wdetailss = userWorkDetails::where('employee_auto_id', '=', $at->employee_auto_id)->get();
                                if ($wdetailss->isNotEmpty()) {
                                    foreach ($wdetailss as $wdata) {
                                        $wfdetails[] = array("work_details_auto_id" => $wdata->_id, "company_name" => $wdata->company_name, "designation" => $wdata->designation, "work_from" => $wdata->work_from, "project_count" => $wdata->project_count, "total_year_experience" => $wdata->total_year_experience, "description_of_project" => $wdata->description_of_project);
                                    }
                                } else {
                                    $wfdetails = array();
                                }
                                $ratings = RateEmployee::where('employee_auto_id', $at->employee_auto_id)->get();
                                $averageRating = $ratings->isNotEmpty() ? $ratings->avg('rate') : null;
                                $atdetailsss[] = array(
                                    "_id" => $at->_id,
                                    "resume" => $at->resume,
                                    "video_resume" => $at->video_resume,
                                    "profile_picture" => $at->profile_picture,
                                    "first_name" => $at->first_name,
                                    "middle_name" => $at->middle_name,
                                    "last_name" => $at->last_name,
                                    "gender" => $at->gender,
                                    "date_of_birth" => $at->date_of_birth,
                                    "address" => $at->address,
                                    "city" => $at->city,
                                    "pincode" => $at->pincode,
                                    "fresher_or_experienced" => $at->fresher_or_experienced,
                                    "skills" => $at->skills,
                                    "prefered_jobrole" => $at->prefered_jobrole,
                                    "prefered_job_locaion" => $at->prefered_job_locaion,
                                    "preferred_job_type" => $at->preferred_job_type,
                                    "field_of_experience" => $at->field_of_experience,
                                    "total_year_experience" => $at->total_year_experience,
                                    "employment_type" => $at->employment_type,
                                    "description_of_project" => $at->description_of_project,
                                    "advance_skills" => $at->advance_skills,
                                    "current_ctc" => $at->current_ctc,
                                    "expected_ctc" => $at->expected_ctc,
                                    "preferred_shift" => $at->preferred_shift,
                                    "open_to_work" => $at->open_to_work,
                                    "adhaar_card_img_front" => $at->adhaar_card_img_front,
                                    "adhaar_card_img_back" => $at->adhaar_card_img_back,
                                    "last_seen_datetime" => $at->last_seen_datetime,
                                    "mark_as_hired" => $at->mark_as_hired,
                                    "average_rating" => $averageRating,
                                    "Qualifications_data" => $quadetails,
                                    "work_details_data" => $wfdetails
                                );
                            }
                        } else {
                            $atdetailsss = array();
                        }
                        $ractions = RecruiterAction::where('candidate_id', '=', $uts->id)->where('job_auto_id', '=', $curs->job_auto_id)->where('employer_auto_id', '=', $request->get('employer_auto_id'))->get();
                        if ($ractions->isNotEmpty()) {
                            foreach ($ractions as $actions) {
                                $recruiter_action_auto_id =  $actions->_id;
                                $employer_auto_id =  $actions->employer_auto_id;
                                $hiring_status =  $actions->hiring_status;
                                $priority =  $actions->priority;
                                $rating =  $actions->rating;
                                $flag =  $actions->flag;

                                // $cractions[] = array("recruiter_action_auto_id"=>$actions->_id,"employer_auto_id"=>$actions->employer_auto_id,"hiring_status"=>$actions->hiring_status,"priority"=>$actions->priority,"rating"=>$actions->rating,"flag"=>$actions->flag);
                            }
                        } else {
                            $recruiter_action_auto_id =  '';
                            $employer_auto_id =  '';
                            $hiring_status =  '';
                            $priority =  '';
                            $rating =  '';
                            $flag =  '';
                            // $cractions = array();
                        }
                        $jobdetails = Jobs::where('_id', '=', $curs->job_auto_id)->where('employer_auto_id', '=', $request->get('employer_auto_id'))->get();
                        if ($jobdetails->isNotEmpty()) {
                            foreach ($jobdetails as $js) {
                                $job_role =  $js->job_role;
                            }
                        } else {
                            $job_role =  '';
                        }
                        $atdatewisetdetailss[] = array(
                            "job_auto_id" => $curs->job_auto_id,
                            "job_role" => $job_role,
                            "employee_auto_id" => $uts->_id,
                            "name" => $uts->name,
                            "email_id" => $uts->email_id,
                            "mobile_number" => $uts->mobile_number,
                            "status" => $uts->status,
                            "Register_as" => $uts->Register_as,
                            "profile_photo" => $uts->profile_photo,
                            "register_date" => $uts->register_date,
                            "recruiter_action_auto_id" => $recruiter_action_auto_id,
                            "employer_auto_id" => $employer_auto_id,
                            "hiring_status" => $hiring_status,
                            "priority" => $priority,
                            "rating" => $rating,
                            "flag" => $flag,
                            "other_details" => $atdetailsss
                        );
                    }
                } else {
                    $atdatewisetdetailss = array();
                }
            }
            return response()->json([
                'status' => 1,
                'data' => $atdatewisetdetailss,
            ]);
        }
    }
    public function update_Candidate_status(Request $request)
    {

        $babout = RecruiterAction::where('employer_auto_id', $request->employer_auto_id)->where('candidate_id', $request->candidate_id)->where('job_auto_id', $request->job_auto_id)->where('_id', $request->recruiter_action_auto_id)->get();
        if ($babout->isNotEmpty()) {
            $babout = RecruiterAction::find($request->get('recruiter_action_auto_id'));
            if ($request->get('hiring_status') != '') {
                $babout->hiring_status = $request->get('hiring_status');
            } else {
                $babout->hiring_status = "";
            }
            if ($request->get('priority') != '') {
                $babout->priority = $request->get('priority');
            } else {
                $babout->priority = "";
            }
            if ($request->get('rating') != '') {
                $babout->rating = $request->get('rating');
            } else {
                $babout->rating = "";
            }
            if ($request->get('flag') != '') {
                $babout->flag = $request->get('flag');
            } else {
                $babout->flag = "";
            }
            $babout->save();

            return response()->json([
                'status' => 1,
                'msg' => "Updated Successfully",
            ]);
        } else {

            $emp = new RecruiterAction();
            $emp->candidate_id = $request->get('candidate_id');
            $emp->employer_auto_id = $request->get('employer_auto_id');
            $emp->job_auto_id = $request->get('job_auto_id');
            if ($request->get('hiring_status') != '') {
                $emp->hiring_status = $request->get('hiring_status');
            } else {
                $emp->hiring_status = "";
            }
            if ($request->get('priority') != '') {
                $emp->priority = $request->get('priority');
            } else {
                $emp->priority = "";
            }
            if ($request->get('rating') != '') {
                $emp->rating = $request->get('rating');
            } else {
                $emp->rating = "";
            }
            if ($request->get('flag') != '') {
                $emp->flag = $request->get('flag');
            } else {
                $emp->flag = "";
            }
            $emp->save();

            return response()->json([
                'status' => 1,
                'msg' => "Added Successfully",
            ]);
        }
    }
    //employer employees
    public function get_recruiter_action_jobList(Request $request)
    {

        $recruiters_action = RecruiterAction::where('candidate_id', '=', $request->get('candidate_id'))->get();
        if ($recruiters_action->isEmpty()) {
            return response()->json([
                'status' => 0,
                "msg" => "No Data Available"
            ]);
        } else {
            foreach ($recruiters_action as $curs) {
                $pcat = Jobs::where('_id', '=', $curs->job_auto_id)->get();
                if ($pcat->isNotEmpty()) {
                    foreach ($pcat as $uts) {
                        $emp_details = UserRegister::where('_id', '=', $uts->employer_auto_id)->where('Register_as', '=', 'Employer')->get();
                        $ractions = RecruiterAction::where('candidate_id', '=', $request->get('candidate_id'))->where('job_auto_id', '=', $curs->job_auto_id)->where('employer_auto_id', '=', $uts->employer_auto_id)->get();
                        if ($ractions->isNotEmpty()) {
                            foreach ($ractions as $actions) {
                                $recruiter_action_auto_id =  $actions->_id;
                                $employer_auto_id =  $actions->employer_auto_id;
                                $hiring_status =  $actions->hiring_status;
                                $priority =  $actions->priority;
                                $rating =  $actions->rating;
                                $flag =  $actions->flag;
                            }
                        } else {
                            $recruiter_action_auto_id =  '';
                            $employer_auto_id =  '';
                            $hiring_status =  '';
                            $priority =  '';
                            $rating =  '';
                            $flag =  '';
                        }
                        $atdatewisetdetails[] = array(
                            "job_auto_id" => $uts->_id,
                            "employer_auto_id" => $uts->employer_auto_id,
                            "job_role" => $uts->job_role,
                            "job_type" => $uts->job_type,
                            "job_location" => $uts->job_location,
                            "required_qualification" => $uts->required_qualification,
                            "min_salary" => $uts->min_salary,
                            "max_salary" => $uts->max_salary,
                            "hide_salary" => $uts->hide_salary,
                            "hiring_process" => $uts->hiring_process,
                            "walkIn_Interview" => $uts->walkIn_Interview,
                            "job_option" => $uts->job_option,
                            "active_status" => $uts->active_status,
                            "experience_from_years" => $uts->experience_from_years,
                            "experience_to_years" => $uts->experience_to_years,
                            "no_of_vacancies" => $uts->no_of_vacancies,
                            "year_of_passing_from" => $uts->year_of_passing_from,
                            "year_of_passing_to" => $uts->year_of_passing_to,
                            "skills" => $uts->skills,
                            "gender" => $uts->gender,
                            "percent" => $uts->percent,
                            "cgpa" => $uts->cgpa,
                            "job_description" => $uts->job_description,
                            "recruiter_email" => $uts->recruiter_email,
                            "recruiter_contact_no" => $uts->recruiter_contact_no,
                            "walkin_location" => $uts->walkin_location,
                            "walk_in_time" => $uts->walk_in_time,
                            "walk_in_date" => $uts->walk_in_date,
                            "recruiter_action_auto_id" => $recruiter_action_auto_id,
                            "employer_auto_id" => $employer_auto_id,
                            "hiring_status" => $hiring_status,
                            "priority" => $priority,
                            "rating" => $rating,
                            "flag" => $flag,
                            "employer_details" => $emp_details
                        );
                    }
                } else {
                    $atdatewisetdetails = array();
                }
            }
            return response()->json([
                'status' => 1,
                'data' => $atdatewisetdetails,
            ]);
        }
    }
    //dashboard count
    public function get_dashboard_count(Request $request)
    {

        $Resume_Rejected = RecruiterAction::where('employer_auto_id', '=', $request->get('employer_auto_id'))->where('hiring_status', '=', 'Resume Rejected')->count();
        $On_hold = RecruiterAction::where('employer_auto_id', '=', $request->get('employer_auto_id'))->where('hiring_status', '=', 'On hold')->count();
        $On_Go = RecruiterAction::where('employer_auto_id', '=', $request->get('employer_auto_id'))->where('hiring_status', '=', 'On Go')->count();
        $Telephonic_Interview = RecruiterAction::where('employer_auto_id', '=', $request->get('employer_auto_id'))->where('hiring_status', '=', 'Telephonic Interview')->count();
        $Technical_Interview = RecruiterAction::where('employer_auto_id', '=', $request->get('employer_auto_id'))->where('hiring_status', '=', 'Technical Interview')->count();
        $HR_Interview = RecruiterAction::where('employer_auto_id', '=', $request->get('employer_auto_id'))->where('hiring_status', '=', 'HR Interview')->count();
        $Final_Interview = RecruiterAction::where('employer_auto_id', '=', $request->get('employer_auto_id'))->where('hiring_status', '=', 'Final Interview')->count();
        $Selected = RecruiterAction::where('employer_auto_id', '=', $request->get('employer_auto_id'))->where('hiring_status', '=', 'Selected')->count();
        $Machine_Test = RecruiterAction::where('employer_auto_id', '=', $request->get('employer_auto_id'))->where('hiring_status', '=', 'Machine Test')->count();

        return response()->json([
            'status' => 1,
            'msg' => 'Success',
            'Resume_Rejected_count' => $Resume_Rejected,
            'On_hold_count' => $On_hold,
            'On_Go_count' => $On_Go,
            'Telephonic_Interview_count' => $Telephonic_Interview,
            'Technical_Interview_count' => $Technical_Interview,
            'Machine_Test_count' => $Machine_Test,
            'HR_Interview_count' => $HR_Interview,
            'Final_Interview_count' => $Final_Interview,
            'Selected_count' => $Selected,
        ]);
    }
    public function get_priority_candidate(Request $request)
    {

        $priority_count = RecruiterAction::where('employer_auto_id', '=', $request->get('employer_auto_id'))->where('priority', '=', $request->get('priority'))->count();

        $recruiters_action = RecruiterAction::where('employer_auto_id', '=', $request->get('employer_auto_id'))->where('priority', '=', $request->get('priority'))->get();
        if ($recruiters_action->isEmpty()) {
            return response()->json([
                'status' => 0,
                "msg" => "No Data Available"
            ]);
        } else {
            foreach ($recruiters_action as $curs) {
                $pcats = UserRegister::where('_id', '=', $curs->candidate_id)->where('Register_as', '=', 'Employee')->get();
                if ($pcats->isNotEmpty()) {
                    foreach ($pcats as $uts) {
                        unset($atdetailsss);
                        $edatass = Employee::where('employee_auto_id', '=', $uts->id)->get();
                        if ($edatass->isNotEmpty()) {
                            foreach ($edatass as $at) {
                                //qualification details
                                unset($quadetails);
                                $qdetailss = userQualificationsDetails::where('employee_auto_id', '=', $at->employee_auto_id)->get();
                                if ($qdetailss->isNotEmpty()) {
                                    foreach ($qdetailss as $qdata) {
                                        $quadetails[] = array("qualification_details_auto_id" => $qdata->_id, "highest_qualification" => $qdata->highest_qualification, "course" => $qdata->course, "university" => $qdata->university, "year_of_completion" => $qdata->year_of_completion, "marks_or_percentage" => $qdata->marks_or_percentage);
                                    }
                                } else {
                                    $quadetails = array();
                                }
                                //work experience
                                unset($wfdetails);
                                $wdetailss = userWorkDetails::where('employee_auto_id', '=', $at->employee_auto_id)->get();
                                if ($wdetailss->isNotEmpty()) {
                                    foreach ($wdetailss as $wdata) {
                                        $wfdetails[] = array("work_details_auto_id" => $wdata->_id, "company_name" => $wdata->company_name, "designation" => $wdata->designation, "work_from" => $wdata->work_from, "project_count" => $wdata->project_count, "total_year_experience" => $wdata->total_year_experience, "description_of_project" => $wdata->description_of_project);
                                    }
                                } else {
                                    $wfdetails = array();
                                }
                                $ratings = RateEmployee::where('employee_auto_id', $at->employee_auto_id)->get();
                                $averageRating = $ratings->isNotEmpty() ? $ratings->avg('rating') : null;
                                $atdetailsss[] = array(
                                    "resume" => $at->resume,
                                    "video_resume" => $at->video_resume,
                                    "profile_picture" => $at->profile_picture,
                                    "first_name" => $at->first_name,
                                    "middle_name" => $at->middle_name,
                                    "last_name" => $at->last_name,
                                    "gender" => $at->gender,
                                    "date_of_birth" => $at->date_of_birth,
                                    "address" => $at->address,
                                    "city" => $at->city,
                                    "pincode" => $at->pincode,
                                    "fresher_or_experienced" => $at->fresher_or_experienced,
                                    "skills" => $at->skills,
                                    "prefered_jobrole" => $at->prefered_jobrole,
                                    "prefered_job_locaion" => $at->prefered_job_locaion,
                                    "preferred_job_type" => $at->preferred_job_type,
                                    "field_of_experience" => $at->field_of_experience,
                                    "total_year_experience" => $at->total_year_experience,
                                    "employment_type" => $at->employment_type,
                                    "description_of_project" => $at->description_of_project,
                                    "advance_skills" => $at->advance_skills,
                                    "current_ctc" => $at->current_ctc,
                                    "expected_ctc" => $at->expected_ctc,
                                    "preferred_shift" => $at->preferred_shift,
                                    "open_to_work" => $at->open_to_work,
                                    "adhaar_card_img_front" => $at->adhaar_card_img_front,
                                    "adhaar_card_img_back" => $at->adhaar_card_img_back,
                                    "last_seen_datetime" => $at->last_seen_datetime,
                                    "average_rating" => $averageRating,
                                    "Qualifications_data" => $quadetails,
                                    "work_details_data" => $wfdetails
                                );
                            }
                        } else {
                            $atdetailsss = array();
                        }
                        $ractions = RecruiterAction::where('candidate_id', '=', $uts->id)->where('job_auto_id', '=', $curs->job_auto_id)->where('employer_auto_id', '=', $request->get('employer_auto_id'))->get();
                        if ($ractions->isNotEmpty()) {
                            foreach ($ractions as $actions) {
                                $recruiter_action_auto_id =  $actions->_id;
                                $employer_auto_id =  $actions->employer_auto_id;
                                $hiring_status =  $actions->hiring_status;
                                $priority =  $actions->priority;
                                $rating =  $actions->rating;
                                $flag =  $actions->flag;

                                // $cractions[] = array("recruiter_action_auto_id"=>$actions->_id,"employer_auto_id"=>$actions->employer_auto_id,"hiring_status"=>$actions->hiring_status,"priority"=>$actions->priority,"rating"=>$actions->rating,"flag"=>$actions->flag);
                            }
                        } else {
                            $recruiter_action_auto_id =  '';
                            $employer_auto_id =  '';
                            $hiring_status =  '';
                            $priority =  '';
                            $rating =  '';
                            $flag =  '';
                            // $cractions = array();
                        }
                        $jobdetails = Jobs::where('_id', '=', $curs->job_auto_id)->where('employer_auto_id', '=', $request->get('employer_auto_id'))->get();
                        if ($jobdetails->isNotEmpty()) {
                            foreach ($jobdetails as $js) {
                                $job_role =  $js->job_role;
                            }
                        } else {
                            $job_role =  '';
                        }
                        $atdatewisetdetailss[] = array(
                            "job_auto_id" => $curs->job_auto_id,
                            "job_role" => $job_role,
                            "employee_auto_id" => $uts->_id,
                            "name" => $uts->name,
                            "email_id" => $uts->email_id,
                            "mobile_number" => $uts->mobile_number,
                            "status" => $uts->status,
                            "Register_as" => $uts->Register_as,
                            "profile_photo" => $uts->profile_photo,
                            "register_date" => $uts->register_date,
                            "recruiter_action_auto_id" => $recruiter_action_auto_id,
                            "employer_auto_id" => $employer_auto_id,
                            "hiring_status" => $hiring_status,
                            "priority" => $priority,
                            "rating" => $rating,
                            "flag" => $flag,
                            "other_details" => $atdetailsss
                        );
                    }
                } else {
                    $atdatewisetdetailss = array();
                }
            }
        }
        return response()->json([
            'status' => 1,
            'msg' => 'Success',
            'priority_count' => $priority_count,
            'data' => $atdatewisetdetailss,
        ]);
    }
    //employee list by status
    public function get_employee_list_by_status(Request $request)
    {

        $cprds = RecruiterAction::where('employer_auto_id', '=', $request->get('employer_auto_id'))->where('hiring_status', '=', $request->get('status'))->get();
        if ($cprds->isEmpty()) {
            return response()->json([
                'status' => 0,
                "msg" => "No Data Available"
            ]);
        } else {

            foreach ($cprds->unique('candidate_id') as $curs) {
                // unset($atdatewisetdetailss);
                $pcats = UserRegister::where('_id', '=', $curs->candidate_id)->where('Register_as', '=', 'Employee')->get();
                if ($pcats->isNotEmpty()) {
                    foreach ($pcats as $uts) {
                        unset($atdetailsss);
                        $edatass = Employee::where('employee_auto_id', '=', $uts->id)->get();
                        if ($edatass->isNotEmpty()) {
                            foreach ($edatass as $at) {
                                //qualification details
                                unset($quadetails);
                                $qdetailss = userQualificationsDetails::where('employee_auto_id', '=', $at->employee_auto_id)->get();
                                if ($qdetailss->isNotEmpty()) {
                                    foreach ($qdetailss as $qdata) {
                                        $quadetails[] = array("qualification_details_auto_id" => $qdata->_id, "highest_qualification" => $qdata->highest_qualification, "course" => $qdata->course, "university" => $qdata->university, "year_of_completion" => $qdata->year_of_completion, "marks_or_percentage" => $qdata->marks_or_percentage);
                                    }
                                } else {
                                    $quadetails = array();
                                }
                                //work experience
                                unset($wfdetails);
                                $wdetailss = userWorkDetails::where('employee_auto_id', '=', $at->employee_auto_id)->get();
                                if ($wdetailss->isNotEmpty()) {
                                    foreach ($wdetailss as $wdata) {
                                        $wfdetails[] = array("work_details_auto_id" => $wdata->_id, "company_name" => $wdata->company_name, "designation" => $wdata->designation, "work_from" => $wdata->work_from, "project_count" => $wdata->project_count, "total_year_experience" => $wdata->total_year_experience, "description_of_project" => $wdata->description_of_project);
                                    }
                                } else {
                                    $wfdetails = array();
                                }
                                $atdetailsss[] = array(
                                    "resume" => $at->resume,
                                    "video_resume" => $at->video_resume,
                                    "profile_picture" => $at->profile_picture,
                                    "first_name" => $at->first_name,
                                    "middle_name" => $at->middle_name,
                                    "last_name" => $at->last_name,
                                    "gender" => $at->gender,
                                    "date_of_birth" => $at->date_of_birth,
                                    "address" => $at->address,
                                    "city" => $at->city,
                                    "pincode" => $at->pincode,
                                    "fresher_or_experienced" => $at->fresher_or_experienced,
                                    "skills" => $at->skills,
                                    "prefered_jobrole" => $at->prefered_jobrole,
                                    "prefered_job_locaion" => $at->prefered_job_locaion,
                                    "preferred_job_type" => $at->preferred_job_type,
                                    "field_of_experience" => $at->field_of_experience,
                                    "total_year_experience" => $at->total_year_experience,
                                    "employment_type" => $at->employment_type,
                                    "description_of_project" => $at->description_of_project,
                                    "advance_skills" => $at->advance_skills,
                                    "current_ctc" => $at->current_ctc,
                                    "expected_ctc" => $at->expected_ctc,
                                    "preferred_shift" => $at->preferred_shift,
                                    "Qualifications_data" => $quadetails,
                                    "work_details_data" => $wfdetails
                                );
                            }
                        } else {
                            $atdetailsss = array();
                        }
                        $ractions = RecruiterAction::where('candidate_id', '=', $uts->id)->where('job_auto_id', '=', $curs->job_auto_id)->where('employer_auto_id', '=', $request->get('employer_auto_id'))->get();
                        if ($ractions->isNotEmpty()) {
                            foreach ($ractions as $actions) {
                                $recruiter_action_auto_id =  $actions->_id;
                                $employer_auto_id =  $actions->employer_auto_id;
                                $hiring_status =  $actions->hiring_status;
                                $priority =  $actions->priority;
                                $rating =  $actions->rating;
                                $flag =  $actions->flag;

                                // $cractions[] = array("recruiter_action_auto_id"=>$actions->_id,"employer_auto_id"=>$actions->employer_auto_id,"hiring_status"=>$actions->hiring_status,"priority"=>$actions->priority,"rating"=>$actions->rating,"flag"=>$actions->flag);
                            }
                        } else {
                            $recruiter_action_auto_id =  '';
                            $employer_auto_id =  '';
                            $hiring_status =  '';
                            $priority =  '';
                            $rating =  '';
                            $flag =  '';
                            // $cractions = array();
                        }
                        $jobdetails = Jobs::where('_id', '=', $curs->job_auto_id)->where('employer_auto_id', '=', $request->get('employer_auto_id'))->get();
                        if ($jobdetails->isNotEmpty()) {
                            foreach ($jobdetails as $js) {
                                $job_role =  $js->job_role;
                            }
                        } else {
                            $job_role =  '';
                        }
                        $atdatewisetdetailss[] = array(
                            "job_auto_id" => $curs->job_auto_id,
                            "job_role" => $job_role,
                            "employee_auto_id" => $uts->_id,
                            "name" => $uts->name,
                            "email_id" => $uts->email_id,
                            "mobile_number" => $uts->mobile_number,
                            "status" => $uts->status,
                            "Register_as" => $uts->Register_as,
                            "profile_photo" => $uts->profile_photo,
                            "register_date" => $uts->register_date,
                            "recruiter_action_auto_id" => $recruiter_action_auto_id,
                            "employer_auto_id" => $employer_auto_id,
                            "hiring_status" => $hiring_status,
                            "priority" => $priority,
                            "rating" => $rating,
                            "flag" => $flag,
                            "other_details" => $atdetailsss
                        );
                    }
                } else {
                    $atdatewisetdetailss = array();
                }
            }
            return response()->json([
                'status' => 1,
                'data' => $atdatewisetdetailss,
            ]);
        }
    }
}
