<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ClassifiedAdd;
use App\Jobs;
use App\UserRegister;
use App\Employee;
use App\CandidateRemainder;
use App\ReportEmployee;
use DateTimeZone;
use App\Professions;
use App\SaveJobs;
use App\WorkingWith;
use App\Qualifications;
use App\userQualificationsDetails;
use App\userWorkDetails;
use App\AdvanceSkills;
use App\Height;
use DateTime;
use DB;
use Illuminate\Support\Facades\Validator;
use App\SearchHistory;
use App\FollowCompany;
use MongoDB\BSON\ObjectId;



class BookingApiController extends Controller
{
        //profession
        public function get_Profession_List()
        {
                $proef = Professions::get();
                if ($proef->isEmpty()) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "No result found",
                        ]);
                } else {
                        return response()->json([
                                'status' => 1,
                                'data' => $proef,
                        ]);
                }
        }
        //get experience
        public function get_skill_list()
        {
                $working = WorkingWith::get();
                if ($working->isEmpty()) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "No result found",
                        ]);
                } else {

                        return response()->json([
                                'status' => 1,
                                'data' => $working,
                        ]);
                }
        }
        //get qualification
        public function get_Education_List()
        {
                $qual = Qualifications::get();
                if ($qual->isEmpty()) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "No result found",
                        ]);
                } else {
                        return response()->json([
                                'status' => 1,
                                'data' => $qual,
                        ]);
                }
        }
        //get locations
        public function get_Locations_List()
        {
                $height = Height::get();
                if ($height->isEmpty()) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "No result found",
                        ]);
                } else {
                        return response()->json([
                                'status' => 1,
                                'data' => $height,
                        ]);
                }
        }
        //get advance skills
        public function get_advance_skills_List()
        {
                $adv = AdvanceSkills::get();
                if ($adv->isEmpty()) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "No result found",
                        ]);
                } else {
                        return response()->json([
                                'status' => 1,
                                'data' => $adv,
                        ]);
                }
        }
        //job post
        public function post_job(Request $request)
        {

                $emp = new Jobs();
                $emp->employer_auto_id = $request->get('employer_auto_id');
                if ($request->get('job_role') != '') {
                        $emp->job_role = $request->get('job_role');
                } else {
                        $emp->job_role = "";
                }
                if ($request->get('job_type') != '') {
                        $emp->job_type = $request->get('job_type');
                } else {
                        $emp->job_type = "";
                }
                if ($request->get('job_location') != '') {
                        $emp->job_location = $request->get('job_location');
                } else {
                        $emp->job_location = "";
                }
                if ($request->get('required_qualification') != '') {
                        $emp->required_qualification = $request->get('required_qualification');
                } else {
                        $emp->required_qualification = "";
                }
                if ($request->get('min_salary') != '') {
                        $emp->min_salary = $request->get('min_salary');
                } else {
                        $emp->min_salary = "";
                }
                if ($request->get('max_salary') != '') {
                        $emp->max_salary = $request->get('max_salary');
                } else {
                        $emp->max_salary = "";
                }
                if ($request->get('hide_salary') != '') {
                        $emp->hide_salary = $request->get('hide_salary');
                } else {
                        $emp->hide_salary = "";
                }
                if ($request->get('hiring_process') != '') {
                        $emp->hiring_process = $request->get('hiring_process');
                } else {
                        $emp->hiring_process = "";
                }
                if ($request->get('walkIn_Interview') != '') {
                        $emp->walkIn_Interview = $request->get('walkIn_Interview');
                } else {
                        $emp->walkIn_Interview = "";
                }
                if ($request->get('job_option') != '') {
                        $emp->job_option = $request->get('job_option');
                } else {
                        $emp->job_option = "";
                }
                if ($request->get('experience_from_years') != '') {
                        $emp->experience_from_years = $request->get('experience_from_years');
                } else {
                        $emp->experience_from_years = "";
                }
                if ($request->get('experience_to_years') != '') {
                        $emp->experience_to_years = $request->get('experience_to_years');
                } else {
                        $emp->experience_to_years = "";
                }
                if ($request->get('no_of_vacancies') != '') {
                        $emp->no_of_vacancies = $request->get('no_of_vacancies');
                } else {
                        $emp->no_of_vacancies = "";
                }
                if ($request->get('year_of_passing_from') != '') {
                        $emp->year_of_passing_from = $request->get('year_of_passing_from');
                } else {
                        $emp->year_of_passing_from = "";
                }
                if ($request->get('year_of_passing_to') != '') {
                        $emp->year_of_passing_to = $request->get('year_of_passing_to');
                } else {
                        $emp->year_of_passing_to = "";
                }
                if ($request->get('skills') != '') {
                        $emp->skills = $request->get('skills');
                } else {
                        $emp->skills = "";
                }
                if ($request->get('gender') != '') {
                        $emp->gender = $request->get('gender');
                } else {
                        $emp->gender = "";
                }
                if ($request->get('percent') != '') {
                        $emp->percent = $request->get('percent');
                } else {
                        $emp->percent = "";
                }
                if ($request->get('cgpa') != '') {
                        $emp->cgpa = $request->get('cgpa');
                } else {
                        $emp->cgpa = "";
                }
                if ($request->get('job_description') != '') {
                        $emp->job_description = $request->get('job_description');
                } else {
                        $emp->job_description = "";
                }
                if ($request->get('recruiter_email') != '') {
                        $emp->recruiter_email = $request->get('recruiter_email');
                } else {
                        $emp->recruiter_email = "";
                }
                if ($request->get('recruiter_contact_no') != '') {
                        $emp->recruiter_contact_no = $request->get('recruiter_contact_no');
                } else {
                        $emp->recruiter_contact_no = "";
                }
                if ($request->get('active_status') != '') {
                        $emp->active_status = $request->get('active_status');
                } else {
                        $emp->active_status = "";
                }
                if ($request->get('walk_in_date') != '') {
                        $emp->walk_in_date = $request->get('walk_in_date');
                } else {
                        $emp->walk_in_date = "";
                }
                if ($request->get('walk_in_time') != '') {
                        $emp->walk_in_time = $request->get('walk_in_time');
                } else {
                        $emp->walk_in_time = "";
                }
                if ($request->get('walkin_location') != '') {
                        $emp->walkin_location = $request->get('walkin_location');
                } else {
                        $emp->walkin_location = "";
                }
                if ($request->get('incentives') != '') {
                        $emp->incentives = $request->get('incentives');
                } else {
                        $emp->incentives = "";
                }
                if ($request->get('benefits') != '') {
                        $emp->benefits = $request->get('benefits');
                } else {
                        $emp->benefits = "";
                }
                if ($request->get('allowances') != '') {
                        $emp->allowances = $request->get('allowances');
                } else {
                        $emp->allowances = "";
                }

                $emp->save();

                return response()->json([
                        'status' => 1,
                        'msg' => "Added Successfully",
                ]);
        }
        // Update Profile
        public function edit_job(Request $request)
        {
                $bdetails = Jobs::where('employer_auto_id', $request->employer_auto_id)->where('_id', '=', $request->job_auto_id)->get();
                if ($bdetails->isNotEmpty()) {
                        $emp = Jobs::find($request->get('job_auto_id'));
                        if (empty($emp)) {
                                return response()->json(['status' => '0', "msg" => "No job Found"]);
                        } else {
                                if ($request->get('job_role') != '') {
                                        $emp->job_role = $request->get('job_role');
                                }
                                if ($request->get('job_type') != '') {
                                        $emp->job_type = $request->get('job_type');
                                }
                                if ($request->get('job_location') != '') {
                                        $emp->job_location = $request->get('job_location');
                                }
                                if ($request->get('required_qualification') != '') {
                                        $emp->required_qualification = $request->get('required_qualification');
                                }
                                if ($request->get('min_salary') != '') {
                                        $emp->min_salary = $request->get('min_salary');
                                }
                                if ($request->get('max_salary') != '') {
                                        $emp->max_salary = $request->get('max_salary');
                                }
                                if ($request->get('hide_salary') != '') {
                                        $emp->hide_salary = $request->get('hide_salary');
                                }
                                if ($request->get('hiring_process') != '') {
                                        $emp->hiring_process = $request->get('hiring_process');
                                }
                                if ($request->get('walkIn_Interview') != '') {
                                        $emp->walkIn_Interview = $request->get('walkIn_Interview');
                                }
                                if ($request->get('job_option') != '') {
                                        $emp->job_option = $request->get('job_option');
                                }
                                if ($request->get('experience_from_years') != '') {
                                        $emp->experience_from_years = $request->get('experience_from_years');
                                }
                                if ($request->get('experience_to_years') != '') {
                                        $emp->experience_to_years = $request->get('experience_to_years');
                                }
                                if ($request->get('no_of_vacancies') != '') {
                                        $emp->no_of_vacancies = $request->get('no_of_vacancies');
                                }
                                if ($request->get('year_of_passing_from') != '') {
                                        $emp->year_of_passing_from = $request->get('year_of_passing_from');
                                }
                                if ($request->get('year_of_passing_to') != '') {
                                        $emp->year_of_passing_to = $request->get('year_of_passing_to');
                                }
                                if ($request->get('skills') != '') {
                                        $emp->skills = $request->get('skills');
                                }
                                if ($request->get('gender') != '') {
                                        $emp->gender = $request->get('gender');
                                }
                                if ($request->get('percent') != '') {
                                        $emp->percent = $request->get('percent');
                                }
                                if ($request->get('cgpa') != '') {
                                        $emp->cgpa = $request->get('cgpa');
                                }
                                if ($request->get('job_description') != '') {
                                        $emp->job_description = $request->get('job_description');
                                }
                                if ($request->get('recruiter_email') != '') {
                                        $emp->recruiter_email = $request->get('recruiter_email');
                                }
                                if ($request->get('recruiter_contact_no') != '') {
                                        $emp->recruiter_contact_no = $request->get('recruiter_contact_no');
                                }
                                if ($request->get('active_status') != '') {
                                        $emp->active_status = $request->get('active_status');
                                }
                                if ($request->get('walk_in_date') != '') {
                                        $emp->walk_in_date = $request->get('walk_in_date');
                                }
                                if ($request->get('walk_in_time') != '') {
                                        $emp->walk_in_time = $request->get('walk_in_time');
                                }
                                if ($request->get('walkin_location') != '') {
                                        $emp->walkin_location = $request->get('walkin_location');
                                }
                                if ($request->get('incentives') != '') {
                                        $emp->incentives = $request->get('incentives');
                                }
                                if ($request->get('benefits') != '') {
                                        $emp->benefits = $request->get('benefits');
                                }
                                if ($request->get('allowances') != '') {
                                        $emp->allowances = $request->get('allowances');
                                }
                                $emp->save();

                                return response()->json(['status' => '1', "msg" => config('messages.success'), 'data' => $emp]);
                        }
                } else {
                        return response()->json([
                                'status' => 0,
                                'msg' => 'Someting went wrong',
                        ]);
                }
        }
        // Update job status 
        public function update_job_status(Request $request)
        {
                $actjobs = Jobs::where('employer_auto_id', $request->employer_auto_id)->where('_id', '=', $request->job_auto_id)->where('active_status', '!=', $request->status)->get();
                if ($actjobs->isNotEmpty()) {
                        $ajobs = Jobs::find($request->get('job_auto_id'));
                        if (empty($ajobs)) {
                                return response()->json(['status' => '0', "msg" => "No job Found"]);
                        } else {

                                if ($request->get('status') != '') {
                                        $ajobs->active_status = $request->get('status');
                                }

                                $ajobs->save();

                                return response()->json(['status' => '1', "msg" => config('messages.success')]);
                        }
                } else {
                        return response()->json([
                                'status' => 0,
                                'msg' => 'Someting went wrong',
                        ]);
                }
        }
        public function get_job_list_employer(Request $request)
        {

                $bdetails = Jobs::ORDERBY('id', '=', 'DESC')->where('employer_auto_id', $request->employer_auto_id)->where('active_status', '=', 'Active')->get();
                if ($bdetails->isEmpty()) {
                        return response()->json([
                                'status' => 0,
                                'msg' => config('messages.empty'),
                        ]);
                } else {
                        return response()->json([
                                'status' => 1,
                                'data' => $bdetails,
                        ]);
                }
        }
        public function get_active_joblist(Request $request)
        {

                $acjdetails = Jobs::ORDERBY('id', '=', 'DESC')->where('employer_auto_id', $request->employer_auto_id)->where('active_status', '=', $request->active_status)->get();
                if ($acjdetails->isEmpty()) {
                        return response()->json([
                                'status' => 0,
                                'msg' => config('messages.empty'),
                        ]);
                } else {
                        return response()->json([
                                'status' => 1,
                                'data' => $acjdetails,
                        ]);
                }
        }
        public function get_walkin_job(Request $request)
        {

                $validator = Validator::make($request->all(), [
                        'employee_auto_id' => 'required|string',
                        'date' => 'required|date_format:Y-m-d',
                ]);

                if ($validator->fails()) {
                        return response()->json([
                                'status' => 0,
                                'msg' => $validator->errors()->first(),
                        ], 400);
                }

                $employee_auto_id = $request->get('employee_auto_id');
                $date = $request->get('date');
                $temp = [];

                $wjdetails = Jobs::ORDERBY('id', '=', 'DESC')->where('walkIn_Interview', '=', 'Yes')->where('active_status', '=', 'Active')->get();
                if ($wjdetails->isNotEmpty()) {
                        foreach ($wjdetails as $slot) {

                                $walk_in_dates = explode(',', $slot->walk_in_date);

                                foreach ($walk_in_dates as $walk_in_date) {
                                        $walk_in_date = trim($walk_in_date);

                                        if (strtotime($date) <= strtotime($walk_in_date)) {
                                                $temp[] = $slot;
                                                break;
                                        }
                                }
                        }
                        $timeslotss = $temp;
                } else {
                        $timeslotss = array();
                }

                if (empty($timeslotss)) {
                        return response()->json([
                                'status' => 0,
                                'msg' => config('messages.empty'),
                        ]);
                } else {
                        foreach (collect($timeslotss) as $uts) {
                                $emp_details = UserRegister::where('_id', '=', $uts->employer_auto_id)->where('Register_as', '=', 'Employer')->get();
                                $save_jobs = SaveJobs::where('job_auto_id', '=', $uts->_id)->where('employee_auto_id', '=', $request->get('employee_auto_id'))->get();
                                if ($save_jobs->isNotEmpty()) {
                                        foreach ($save_jobs as $actions) {
                                                $is_save_job =  $actions->is_save_job;
                                        }
                                } else {
                                        $is_save_job =  '';
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
                                        "is_save_job" => $is_save_job,
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
                                        "employer_details" => $emp_details
                                );
                        }
                        return response()->json([
                                'status' => 1,
                                'data' => $atdatewisetdetails,
                        ]);
                }
        }
        public function get_job_list_employee(Request $request)
        {
                $job_skill = $request->input('job_skill');
                $job_role = $request->input('job_role');
                $location = $request->input('location');
                $walkIn_Interview = $request->input('walkIn_Interview');
                $date = $request->input('date');
                $experience = $request->input('experience');


                $conditions = array();

                $location_ids = [];
                $job_role_ids = [];
                $job_skill_ids = [];

                if ($request->get('location') != "") {
                        $location_ids = array_map('trim', explode(',', $request->get('location'))); // Trim spaces
                        $location_conditions = [];

                        foreach ($location_ids as $location) {
                                $location_conditions[] = ['job_location' => new \MongoDB\BSON\Regex('(^|,)\s*' . preg_quote(
                                        $location,
                                        '/'
                                ) . '\s*(,|$)', 'i')];
                        }

                        array_push($conditions, ['condition' => 'or', 'value' => $location_conditions]);
                }
                if ($request->get('job_role') != "") {
                        $job_role_ids = explode(',', $request->get('job_role'));
                        array_push($conditions, array('field' => 'job_role', 'value' => $job_role_ids, 'condition' => 'orwhereIn'));
                }
                if ($request->get('job_skill') != "") {
                        $job_skill_ids = explode(',', $request->get('job_skill'));
                        $skill_conditions = [];

                        foreach ($job_skill_ids as $skill) {
                                $skill_conditions[] = ['skills' => new \MongoDB\BSON\Regex("\\b" . trim($skill) . "\\b", 'i')];
                        }

                        array_push($conditions, ['condition' => 'or', 'value' => $skill_conditions]);
                }
                if ($request->get('walkin_interview') != "") {
                        array_push($conditions, [
                                'field' => 'walkIn_Interview',
                                'value' => $request->get('walkin_interview'),
                                'condition' => 'where'
                        ]);
                }
                if ($request->get('employer_auto_id') != "") {
                        array_push($conditions, [
                                'field' => 'employer_auto_id',
                                'value' => $request->get('employer_auto_id'),
                                'condition' => 'where'
                        ]);
                }

                $joblists = Jobs::where(function ($q) use ($conditions) {
                        foreach ($conditions as $key) {
                                if ($key['condition'] == 'or') {
                                        $q->where(function ($subQuery) use ($key) {
                                                foreach ($key['value'] as $condition) {
                                                        $subQuery->orWhere($condition);
                                                }
                                        });
                                } elseif ($key['condition'] == "orwhereIn") {
                                        $q->orwhereIn($key['field'], $key['value']);
                                } elseif ($key['condition'] == ">where") {
                                        $q->where($key['field'], ">=", strval($key['value']));
                                } elseif ($key['condition'] == ">orwhere") {
                                        $q->where($key['field'], ">=", strval($key['value']));
                                } else {
                                        $q->where($key['field'], "=", $key['value']);
                                }
                        }
                })->where('active_status', '=', 'Active')->get();

                //  $joblist = Jobs::where('active_status','=','Active')->orWhere('skills', 'LIKE', "%{$searches}%")->orWhere('job_role', 'LIKE', "%{$searches}%")->orWhere('job_location', 'LIKE', "%{$searches}%")->get();
                if ($joblists->isEmpty()) {
                        return response()->json([
                                'status' => 0,
                                'msg' => config('messages.empty'),
                        ]);
                } else {
                        $atdatewisetdetails = [];
                        foreach ($joblists as $uts) {
                                $emp_details = UserRegister::where('_id', '=', $uts->employer_auto_id)->where('Register_as', '=', 'Employer')->get();
                                $save_jobs = SaveJobs::where('job_auto_id', '=', $uts->_id)->where('employee_auto_id', '=', $request->get('employee_auto_id'))->get();
                                if ($save_jobs->isNotEmpty()) {
                                        foreach ($save_jobs as $actions) {
                                                $is_save_job =  $actions->is_save_job;
                                        }
                                } else {
                                        $is_save_job =  '';
                                }

                                if (!empty($experience)) {
                                        $experience = intval(trim($experience));
                                        $experience_from = intval($uts->experience_from_years);
                                        $experience_to = intval($uts->experience_to_years);

                                        if (
                                                $experience_from > $experience || $experience_to <
                                                $experience
                                        ) {
                                                continue;
                                        }
                                }

                                if (!empty($date)) {
                                        $jobDates = explode(',', $uts->walk_in_date);


                                        $inputDate = strtotime($date);
                                        $walkInTimestamps = array_map('strtotime', $jobDates);

                                        // Find the earliest walk-in date
                                        $earliestWalkInDate = min($walkInTimestamps);

                                        // Condition: If date is in jobDates OR it's older than all walk-in dates, show the job
                                        if (!in_array($date, $jobDates) && $inputDate > $earliestWalkInDate) {
                                                continue; // Skip the job only if the input date is NOT in the list AND is newer
                                        }
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
                                        "is_save_job" => $is_save_job,
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
                                        "employer_details" => $emp_details
                                );
                        }
                        return response()->json([
                                'status' => 1,
                                'msg' => 'Success',
                                'data' => $atdatewisetdetails,
                        ]);
                }
        }
        public function get_candidate_search(Request $request)
        {
                $location = $request->input('location');
                $job_role = $request->input('job_role');
                $experience = $request->input('experience');
                $job_type = $request->input('job_type');
                $gender = $request->input('gender');
                $ctc = $request->input('ctc');
                $open_to_work = $request->input('open_to_work');
                $skills = $request->input('skills');
                $rating = $request->input('rating');
                // $searchlists = explode(',', $search);
                $conditions = array();

                $location_ids = [];
                $job_role_ids = [];
                $experience_ids = [];
                $job_type_ids = [];
                $gender_ids = [];
                $ctc_ids = [];
                $skills_ids = [];
                if ($request->get('location') != "") {
                        $location_ids = explode(',', $request->get('location'));
                        array_push($conditions, array('field' => 'city', 'value' => $location_ids, 'condition' => 'orwhereIn'));
                }
                if ($request->get('job_role') != "") {
                        $job_role_ids = explode(',', $request->get('job_role'));
                        array_push($conditions, array('field' => 'prefered_jobrole', 'value' => $job_role_ids, 'condition' => 'orwhereIn'));
                }
                if ($request->get('experience') != "") {
                        $experience_ids = explode(',', $request->get('experience'));
                        array_push($conditions, array('field' => 'total_year_experience', 'value' => $experience_ids, 'condition' => 'orwhereIn'));
                }
                if ($request->get('job_type') != "") {
                        $job_type_ids = explode(',', $request->get('job_type'));
                        array_push($conditions, array('field' => 'preferred_job_type', 'value' => $job_type_ids, 'condition' => 'orwhereIn'));
                }
                if ($request->get('gender') != "") {
                        $gender_ids = explode(',', $request->get('gender'));
                        array_push($conditions, array('field' => 'gender', 'value' => $gender_ids, 'condition' => 'orwhereIn'));
                }
                if ($request->get('ctc') != "") {
                        $ctc_ids = explode(',', $request->get('ctc'));
                        array_push($conditions, array('field' => 'expected_ctc', 'value' => $ctc_ids, 'condition' => 'orwhereIn'));
                }
                if ($request->get('open_to_work') != "") {
                        array_push($conditions, array(
                                'field' => 'open_to_work',
                                'value' => [$request->get('open_to_work')],
                                'condition' =>
                                'orwhereIn'
                        ));
                }
                if ($request->get('skills') != "") {
                        $skills_ids = explode(',', $request->get('skills'));
                        foreach ($skills_ids as $skill) {
                                $conditions[] = [
                                        'field' => 'skills',
                                        'value' => new \MongoDB\BSON\Regex(trim($skill), 'i'), // Case-insensitive search
                                        'condition' => 'orWhere'
                                ];
                        }
                }




                $emplists = Employee::where(function ($q) use ($conditions) {
                        foreach ($conditions as $key) {
                                if ($key['condition'] == "whereIn") {
                                        $q->whereIn($key['field'], $key['value']);
                                } elseif ($key['condition'] == "orwhereIn") {
                                        $q->orwhereIn($key['field'], $key['value']);
                                } elseif ($key['condition'] == ">where") {
                                        $q->where($key['field'], ">=", strval($key['value']));
                                } elseif ($key['condition'] == ">orwhere") {
                                        $q->where($key['field'], ">=", strval($key['value']));
                                } elseif ($key['condition'] == "orWhere") {
                                        $q->orWhere($key['field'], 'regexp', $key['value']);
                                } else {
                                        $q->where($key['field'], "=", $key['value']);
                                }
                        }
                })->get();

                // $emplist = Employee::orWhereIn('city', 'LIKE', "%{$location}%")->orWhereIn('prefered_jobrole', 'LIKE', "%{$job_role}%")->orWhereIn('total_year_experience', 'LIKE', "%{$experience}%")->orWhereIn('preferred_job_type', 'LIKE', "%{$job_type}%")->orWhereIn('gender', 'LIKE', "%{$gender}%")->orWhereIn('expected_ctc', 'LIKE', "%{$ctc}%")->get();
                if ($emplists->isEmpty()) {
                        return response()->json([
                                'status' => 0,
                                'msg' => config('messages.empty'),
                        ]);
                } else {


                        if ($rating === "yes") {
                                $emplists = $emplists->sortByDesc('rating'); // Use sortByDesc for collections
                        }

                        foreach ($emplists as $at) {
                                $pcat = UserRegister::where('_id', '=', $at->employee_auto_id)->where('Register_as', '=', 'Employee')->get();
                                if ($pcat->isNotEmpty()) {
                                        foreach ($pcat as $uts) {
                                                $name = $uts->name;
                                                $email_id = $uts->email_id;
                                                $mobile_number = $uts->mobile_number;
                                                $status = $uts->status;
                                                $Register_as = $uts->Register_as;
                                                $profile_photo = $uts->profile_photo;
                                                $register_date = $uts->register_date;
                                        }
                                } else {
                                        $name = '';
                                        $email_id = '';
                                        $mobile_number = '';
                                        $status = '';
                                        $Register_as = '';
                                        $profile_photo = '';
                                        $register_date = '';
                                }
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

                                unset($atdetails);
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
                                        "project_count" => $at->project_count,
                                        "description_of_project" => $at->description_of_project,
                                        "advance_skills" => $at->advance_skills,
                                        "current_ctc" => $at->current_ctc,
                                        "expected_ctc" => $at->expected_ctc,
                                        "Qualifications_data" => $quadetails,
                                        "work_details_data" => $wfdetails,
                                        "rating" => $at->rating
                                );

                                $details[] = array(
                                        "employee_auto_id" => $at->employee_auto_id,
                                        "name" => $name,
                                        "email_id" => $email_id,
                                        "mobile_number" => $mobile_number,
                                        "status" => $status,
                                        "Register_as" => $Register_as,
                                        "profile_photo" => $profile_photo,
                                        "register_date" => $register_date,
                                        "is_bookmark" => 'Yes',
                                        "other_details" => $atdetails
                                );
                        }
                        return response()->json([
                                'status' => 1,
                                'candidate_details' => $details,
                        ]);
                }
        }
        //delete jobs
        public function delete_job(Request $request)
        {
                $tdetailss = Jobs::where('employer_auto_id', $request->employer_auto_id)->where('_id', '=', $request->job_auto_id)->get();
                if ($tdetailss) {
                        $tdetlss = Jobs::find($request->job_auto_id);
                        $tdetlss->delete();

                        return response()->json([
                                'status' => 1,
                                'msg' => "Sucessfully Deleted"
                        ]);
                } else {

                        return response()->json([
                                'status' => 0,
                                'msg' => "Something went wrong"
                        ]);
                }
        }
        // get list of search
        public function get_job_search_list()
        {
                //location list
                $location_details = Height::get();
                if ($location_details->isNotEmpty()) {
                        foreach ($location_details as $mdetails) {
                                $searchlist[] = array("title" => $mdetails->location, "id" => $mdetails->id, "type" => "Locations");
                        }
                }

                // job skills
                $skill_details = WorkingWith::get();
                if ($skill_details->isNotEmpty()) {
                        foreach ($skill_details as $sdetails) {
                                $searchlist[] = array("title" => $sdetails->name, "id" => $sdetails->id, "type" => "Skills");
                        }
                }

                //job role
                $job_role = Professions::get();
                if ($job_role->isNotEmpty()) {
                        foreach ($job_role as $cdetails) {
                                $searchlist[] = array("title" => $cdetails->name, "id" => $cdetails->id, "type" => "JobRole");
                        }
                }

                if (empty($searchlist)) {
                        return response()->json([
                                'status' => 0,
                                'msg' => config('messages.empty'),
                        ]);
                } else {
                        return response()->json([
                                'status' => 1,
                                'msg' => "Success",
                                'allsearchlist' => $searchlist,
                        ]);
                }
        }

        //Search History
        public function createSearchHistory(Request $request)
        {
                // Check if employee_auto_id is missing
                if (!$request->has('employee_auto_id') || empty($request->get('employee_auto_id'))) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "Employee ID is required.",
                        ], 400);
                }

                // Create a new search history entry
                $searchHistory = new SearchHistory();
                $searchHistory->employee_auto_id = $request->get('employee_auto_id');
                $searchHistory->job_skill = $request->get('job_skill', '');
                $searchHistory->job_role = $request->get('job_role', '');
                $searchHistory->location = $request->get('location', '');
                $searchHistory->walkin_interview = $request->get('walkin_interview', '');

                $searchHistory->save();

                return response()->json([
                        'status' => 1,
                        'msg' => "Search history added successfully",
                ]);
        }

        public function getSearchHistory(Request $request)
        {
                // Check if employee_auto_id is missing
                if (!$request->has('employee_auto_id') || empty($request->get('employee_auto_id'))) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "Employee ID is required.",
                        ], 400);
                }

                // Fetch search history for the given employee_auto_id
                $history = SearchHistory::where('employee_auto_id', $request->get('employee_auto_id'))->get();

                if ($history->isEmpty()) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "No search history found",
                        ]);
                }

                return response()->json([
                        'status' => 1,
                        'msg' => "Success",
                        'data' => $history,
                ]);
        }


        public function getCompanyList(Request $request)
        {
                // Fetch companies where Register_as is 'Employer'
                $company_list = UserRegister::where('Register_as', 'Employer')->get();

                if ($company_list->isEmpty()) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "No Company List found",
                        ]);
                }

                return response()->json([
                        'status' => 1,
                        'msg' => "Success",
                        'data' => $company_list,
                ]);
        }

        public function createCandidateRemainder(Request $request)
        {
                // Check if employee_auto_id is missing
                if (!$request->has('employer_auto_id') || empty($request->get('employer_auto_id'))) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "Employer ID is required.",
                        ], 400);
                }

                if (!$request->has('employee_auto_id') || empty($request->get('employee_auto_id'))) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "Employee ID is required.",
                        ], 400);
                }

                $CandidateRemainder = new CandidateRemainder();
                $CandidateRemainder->employee_auto_id = $request->get('employee_auto_id');
                $CandidateRemainder->employer_auto_id = $request->get('employer_auto_id');
                $CandidateRemainder->call_date = $request->get('call_date', '');
                $CandidateRemainder->call_time = $request->get('call_time', '');

                $CandidateRemainder->save();

                return response()->json([
                        'status' => 1,
                        'msg' => "Candidate Remainder added successfully",
                ]);
        }

        public function getCandidateRemainder(Request $request)
        {
                if (!$request->has('employer_auto_id') || empty($request->get('employer_auto_id'))) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "Employer ID is required.",
                        ], 400);
                }


                $remainder = CandidateRemainder::where('employer_auto_id', $request->get('employer_auto_id'))->get();

                if ($remainder->isEmpty()) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "No search history found",
                        ]);
                }

                return response()->json([
                        'status' => 1,
                        'msg' => "Success",
                        'data' => $remainder,
                ]);
        }


        public function deleteCandidateRemainder(Request $request)
        {
                // Validate required parameters
                if (!$request->has('remainder_auto_id') || empty($request->get('remainder_auto_id'))) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "Remainder ID is required.",
                        ], 400);
                }

                if (!$request->has('employer_auto_id') || empty($request->get('employer_auto_id'))) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "Employer ID is required.",
                        ], 400);
                }

                try {

                        $remainderId = new ObjectId($request->get('remainder_auto_id'));


                        $remainder = CandidateRemainder::where('_id', $remainderId)
                                ->where('employer_auto_id', $request->get('employer_auto_id'))
                                ->first();


                        if (!$remainder) {
                                return response()->json([
                                        'status' => 0,
                                        'msg' => "No remainder found.",
                                ]);
                        }


                        $remainder->delete();

                        return response()->json([
                                'status' => 1,
                                'msg' => "Remainder deleted successfully.",
                        ]);
                } catch (\Exception $e) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "Invalid remainder ID format.",
                        ], 400);
                }
        }

        public function createReportEmployee(Request $request)
        {
                // Check if employee_auto_id is missing
                if (!$request->has('employer_auto_id') || empty($request->get('employer_auto_id'))) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "Employer ID is required.",
                        ], 400);
                }

                if (!$request->has('employee_auto_id') || empty($request->get('employee_auto_id'))) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "Employee ID is required.",
                        ], 400);
                }

                $ReportEmployee = new ReportEmployee();
                $ReportEmployee->employee_auto_id = $request->get('employee_auto_id');
                $ReportEmployee->employer_auto_id = $request->get('employer_auto_id');
                $ReportEmployee->reason = $request->get('reason', '');

                $ReportEmployee->save();

                return response()->json([
                        'status' => 1,
                        'msg' => "Employee Reported successfully",
                ]);
        }

        public function followUnfollowCompany(Request $request)
        {
             
                if (!$request->has('follow_id') || empty($request->get('follow_id'))) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "Follow ID is required.",
                        ], 400);
                }

                if (!$request->has('employee_auto_id') || empty($request->get('employee_auto_id'))) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "Employee ID is required.",
                        ], 400);
                }

                if (!$request->has('follow')) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "Follow status is required.",
                        ], 400);
                }

                try {
                        $followStatus = filter_var($request->get('follow'), FILTER_VALIDATE_BOOLEAN);

                        // Fetch existing record
                        $existingRecord = FollowCompany::where('follow_id', $request->get('follow_id'))
                                ->where('employee_auto_id', $request->get('employee_auto_id'))
                                ->first();

                        if ($existingRecord) {
                                // Update follow status
                                $existingRecord->follow = $followStatus;
                                $existingRecord->save();

                                return response()->json([
                                        'status' => 1,
                                        'msg' => "Follow status updated successfully.",
                                ]);
                        } else {
                                // Create new record
                                $FollowCompany = new FollowCompany();
                                $FollowCompany->follow_id = $request->get('follow_id');
                                $FollowCompany->employee_auto_id = $request->get('employee_auto_id');
                                $FollowCompany->follow = $followStatus;
                                $FollowCompany->save();
                                return response()->json([
                                        'status' => 1,
                                        'msg' => "Follow status added successfully.",
                                ]);
                        }
                } catch (\Exception $e) {
                        return response()->json([
                                'status' => 0,
                                'msg' => "Invalid Follow ID or Employee ID format.",
                        ], 400);
                }
        }
}
