<?php

namespace App\Http\Controllers\Admin;

use App\Jobs;
use App\Height;
use App\Professions;
use App\WorkingWith;
use App\Qualifications;
use App\Traits\Features;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class JobsController extends Controller
{

    use Features;

    public function jobs()
    {
        $jobs = Jobs::where('employer_auto_id', "ADMIN")->get();

        $features = $this->getfeatures();
        if (empty($features)) {
            return redirect('MyDashboard')->with('error', "Something went wrong");
        }

        return view('templates.myadmin.jobs')->with([
            'jobs' => $jobs,
        ]);
    }

    public function add_job()
    {
        $job_locations = Height::get();
        $qualifications = Qualifications::get();
        $job_skills = WorkingWith::get();
        $professions = Professions::get();

        $features = $this->getfeatures();
        if (empty($features)) {
            return redirect('MyDashboard')->with('error', "Something went wrong");
        }

        return view('templates.myadmin.add_job')->with([
            'qualifications' => $qualifications,
            'job_locations' => $job_locations,
            'job_skills' => $job_skills,
            'professions' => $professions,
        ]);
    }

    //job post
    public function store_job(Request $request)
    {

        $this->validate(
            $request,
            [
                'job_role' => 'required',
                'job_type' => 'required',
                'job_location' => 'required',
                'required_qualification' => 'required',
                'min_salary' => 'required',
                'max_salary' => 'required',
                'hide_salary' => 'required',
                'walkIn_Interview' => 'required',
                'job_description' => 'required',
                'recruiter_email' => 'required',
                'recruiter_contact_no' => 'required',

            ],
            [
                'job_role.required' => 'Select Job Role',
                'job_type.required' => 'Select Job Type',
                'job_location.required' => 'Select Job Locations',
                'required_qualification.required' => 'Select Job Qualifications Required',
                'min_salary.required' => 'Enter Minimum Salary',
                'max_salary.required' => 'Enter Maximum Salary',
                'hide_salary.required' => 'Select Wheater Salary Show Or Hide',
                'walkIn_Interview.required' => 'Select Interview Type',
                'job_description.required' => 'Enter Job Description',
                'recruiter_email.required' => 'Enter Email ID',
                'recruiter_contact_no.required' => 'Enter Contact Number',
            ]
        );

        $emp = new Jobs();
        $emp->employer_auto_id = "ADMIN";

        $emp->job_role = $request->get('job_role');
        $emp->job_type = $request->get('job_type');

        $emp->job_location = implode(',', $request->get('job_location', []));
        $emp->required_qualification = implode(',', $request->get('required_qualification', []));

        $emp->min_salary = strval($request->get('min_salary'));
        $emp->max_salary = strval($request->get('max_salary'));
        $emp->hide_salary = $request->get('hide_salary');
        $emp->hiring_process =  implode(',', $request->get('hiring_process')) ?? '';
        $emp->job_option = $request->get('job_option') ?? '';
        $emp->walkIn_Interview = $request->get('walkIn_Interview');
        $emp->experience_from_years = $request->get('experience_from_years') ?? '';
        $emp->experience_to_years = $request->get('experience_to_years') ?? '';
        $emp->no_of_vacancies = $request->get('no_of_vacancies') ?? '';
        $emp->year_of_passing_from = $request->get('year_of_passing_from') ?? '';
        $emp->year_of_passing_to = $request->get('year_of_passing_to') ?? '';
        $emp->skills =  implode(',', $request->get('skills'));
        $emp->gender = $request->get('gender') ?? '';
        $emp->percent = $request->get('percent') ?? '';
        $emp->cgpa = $request->get('cgpa') ?? '';
        $emp->job_description = $request->get('job_description') ?? '';
        $emp->recruiter_email = $request->get('recruiter_email');
        $emp->recruiter_contact_no = $request->get('recruiter_contact_no');
        $emp->active_status = $request->get('active_status') ?? 'Active';
        $emp->walk_in_date =  implode(',', $request->get('walk_in_date')) ?? '';
        $emp->walk_in_time =  implode(',', $request->get('walk_in_time')) ?? '';
        $emp->walkin_location =  implode(',', $request->get('walkin_location')) ?? '';
        $emp->incentives = $request->get('incentives') ?? '';
        $emp->benefits = $request->get('benefits') ?? '';
        $emp->allowances = $request->get('allowances') ?? '';
        $emp->save();

        return redirect('jobs')->with('success', 'Added Successfully');
    }


    public function edit_job($id)
    {
        $job_locations = Height::get();
        $qualifications = Qualifications::get();
        $job_skills = WorkingWith::get();
        $professions = Professions::get();

        $features = $this->getfeatures();
        if (empty($features)) {
            return redirect('MyDashboard')->with('error', "Something went wrong");
        }

        $job = Jobs::find($id);

        if (empty($job)) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        return view('templates.myadmin.edit_job')->with([
            'job' => $job,
            'qualifications' => $qualifications,
            'job_locations' => $job_locations,
            'job_skills' => $job_skills,
            'professions' => $professions,
        ]);
    }


    public function update_job(Request $request)
    {

        $this->validate(
            $request,
            [
                'job_id' => 'required',
                'job_role' => 'required',
                'job_type' => 'required',
                'job_location' => 'required',
                'required_qualification' => 'required',
                'min_salary' => 'required',
                'max_salary' => 'required',
                'hide_salary' => 'required',
                'walkIn_Interview' => 'required',
                'job_description' => 'required',
                'recruiter_email' => 'required',
                'recruiter_contact_no' => 'required',

            ],
            [
                'job_role.required' => 'Select Job Role',
                'job_type.required' => 'Select Job Type',
                'job_location.required' => 'Select Job Locations',
                'required_qualification.required' => 'Select Job Qualifications Required',
                'min_salary.required' => 'Enter Minimum Salary',
                'max_salary.required' => 'Enter Maximum Salary',
                'hide_salary.required' => 'Select Wheater Salary Show Or Hide',
                'walkIn_Interview.required' => 'Select Interview Type',
                'job_description.required' => 'Enter Job Description',
                'recruiter_email.required' => 'Enter Email ID',
                'recruiter_contact_no.required' => 'Enter Contact Number',
            ]
        );

        $emp = Jobs::find($request->get('job_id'));

        if (empty($emp)) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $emp->job_role = $request->get('job_role');
        $emp->job_type = $request->get('job_type');
        $emp->job_location = implode(',', $request->get('job_location', []));
        $emp->required_qualification = implode(',', $request->get('required_qualification', []));
        $emp->min_salary = strval($request->get('min_salary'));
        $emp->max_salary = strval($request->get('max_salary'));
        $emp->hide_salary = $request->get('hide_salary');
        $emp->hiring_process =  implode(',', $request->get('hiring_process')) ?? '';
        $emp->job_option = $request->get('job_option') ?? '';
        $emp->walkIn_Interview = $request->get('walkIn_Interview');
        $emp->experience_from_years = $request->get('experience_from_years') ?? '';
        $emp->experience_to_years = $request->get('experience_to_years') ?? '';
        $emp->no_of_vacancies = $request->get('no_of_vacancies') ?? '';
        $emp->year_of_passing_from = $request->get('year_of_passing_from') ?? '';
        $emp->year_of_passing_to = $request->get('year_of_passing_to') ?? '';
        $emp->skills =  implode(',', $request->get('skills'));
        $emp->gender = $request->get('gender') ?? '';
        $emp->percent = $request->get('percent') ?? '';
        $emp->cgpa = $request->get('cgpa') ?? '';
        $emp->job_description = $request->get('job_description') ?? '';
        $emp->recruiter_email = $request->get('recruiter_email');
        $emp->recruiter_contact_no = $request->get('recruiter_contact_no');
        $emp->active_status = $request->get('active_status') ?? 'Active';
        $emp->walk_in_date =  implode(',', $request->get('walk_in_date')) ?? '';
        $emp->walk_in_time =  implode(',', $request->get('walk_in_time')) ?? '';
        $emp->walkin_location =  implode(',', $request->get('walkin_location')) ?? '';
        $emp->incentives = $request->get('incentives') ?? '';
        $emp->benefits = $request->get('benefits') ?? '';
        $emp->allowances = $request->get('allowances') ?? '';
        $emp->save();

        return redirect('jobs')->with('success', 'Added Successfully');
    }

    public function delete_job($id)
    {
        $job = Jobs::find($id);
        if (empty($job)) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
        $job->delete();
        return redirect()->back()->with('success', 'Deleted Successfully');
    }

    public function get_job_list_employer(Request $request)
    {
        $bdetails = Jobs::ORDERBY('id', '=', 'DESC')->where('employer_auto_id', '')->where('active_status', '=', 'Active')->get();
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
}