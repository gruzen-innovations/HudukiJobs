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
use Carbon\Carbon;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\Log;
use MongoDB\BSON\UTCDateTime;


class WholeSalerController extends Controller
{
    use Features;



    public function index(Request $request)
    {
        $query = UserRegister::where('Register_as', '=', 'Employer');

        if ($request->has('range') && $request->has('period')) {
            $range = $request->input('range');
            $period = $request->input('period');

            try {
                if ($range === 'weekly') {
                    $date = Carbon::parse($period);
                    $query->whereBetween('created_at', [
                        new \MongoDB\BSON\UTCDateTime($date->startOfDay()),
                        new \MongoDB\BSON\UTCDateTime($date->endOfDay())
                    ]);
                } elseif ($range === 'monthly') {
                    $month = Carbon::createFromFormat('M', $period)->month;
                    $year = now()->year;
                    $date = Carbon::create($year, $month, 1);

                    $query->whereBetween('created_at', [
                        new \MongoDB\BSON\UTCDateTime($date->startOfMonth()),
                        new \MongoDB\BSON\UTCDateTime($date->endOfMonth())
                    ]);
                } elseif ($range === 'yearly') {
                    $date = Carbon::createFromFormat('Y', $period);
                    $query->whereBetween('created_at', [
                        new \MongoDB\BSON\UTCDateTime($date->startOfYear()),
                        new \MongoDB\BSON\UTCDateTime($date->endOfYear())
                    ]);
                }
            } catch (\Exception $e) {
                // Handle parse errors gracefully
                return redirect()->back()->with('error', 'Invalid date format provided.');
            }
        }


        $wholesaler = $query->get();
        $features = $this->getfeatures();

        if (empty($features)) {
            return redirect('MyDashboard')->with('error', "Something went wrong");
        } else {
            return view('templates.myadmin.user')->with([
                'customers' => $wholesaler,
                'allfeatures' => $features
            ]);
        }
    }



    public function edit($id)
    {
        $wholesaler = UserRegister::where('_id', '=', $id)->where('Register_as', '=', 'Employer')->get();
        $features = $this->getfeatures();
        if (empty($features)) {
            return redirect('MyDashboard')->with('error', "Something went wrong");
        } else {
            return view('templates.myadmin.edit_user')->with(['wholesalers' => $wholesaler, 'allfeatures' => $features]);
        }
    }
    public function view_posted_jobs_list($id)
    {
        $jobs = Jobs::where('employer_auto_id', '=', $id)->where('active_status', '=', 'Active')->get();
        $features = $this->getfeatures();
        if (empty($features)) {
            return redirect('MyDashboard')->with('error', "Something went wrong");
        } else {
            return view('templates.myadmin.view_posted_jobs')->with(['jobs' => $jobs, 'allfeatures' => $features]);
        }
    }

    public function update(Request $request)
    {
        $wholesaler = UserRegister::find($request->input('id'));
        $wholesaler->status = $request->input('status');
        $wholesaler->save();
        return redirect('wholesalers')->with('success', 'Updated Successfully');
    }


    // Make sure Employee model is imported

    public function index_employee(Request $request)
    {
        $query = UserRegister::where('Register_as', '=', 'Employee');

        // 1. Apply range and period filter first (for chart)
        if ($request->has('range') && $request->has('period')) {
            $range = $request->input('range');
            $period = $request->input('period');

            try {
                if ($range === 'weekly') {
                    $date = Carbon::parse($period);
                    $query->whereBetween('created_at', [
                        new \MongoDB\BSON\UTCDateTime($date->startOfDay()),
                        new \MongoDB\BSON\UTCDateTime($date->endOfDay())
                    ]);
                } elseif ($range === 'monthly') {
                    $month = Carbon::createFromFormat('M', $period)->month;
                    $year = now()->year;
                    $date = Carbon::create($year, $month, 1);

                    $query->whereBetween('created_at', [
                        new \MongoDB\BSON\UTCDateTime($date->startOfMonth()),
                        new \MongoDB\BSON\UTCDateTime($date->endOfMonth())
                    ]);
                } elseif ($range === 'yearly') {
                    $date = Carbon::createFromFormat('Y', $period);
                    $query->whereBetween('created_at', [
                        new \MongoDB\BSON\UTCDateTime($date->startOfYear()),
                        new \MongoDB\BSON\UTCDateTime($date->endOfYear())
                    ]);
                }
            } catch (\Exception $e) {
                // Handle parse errors gracefully
                return redirect()->back()->with('error', 'Invalid date format provided.');
            }
        }



        // 2. If active=today is requested
        if ($request->has('active') && $request->input('active') === 'today') {
            $today = Carbon::now()->format('Y-m-d');

            // Get employees from Employee model with today's activity
            $activeEmployeeIds = Employee::all()->filter(function ($emp) use ($today) {
                if (!isset($emp->last_seen_datetime)) return false;

                $parts = explode(',', $emp->last_seen_datetime);
                if (count($parts) < 2) return false;
                $datePart = trim($parts[1]);
                try {
                    $parsedDate = Carbon::createFromFormat('d M Y', $datePart)->format('Y-m-d');
                    return $parsedDate === $today;
                } catch (\Exception $e) {
                    return false;
                }
            })->pluck('employee_auto_id')->toArray();

            // Fetch from UserRegister where employee_auto_id is in active list


            $query = $query->whereIn('_id', array_filter(array_map(function ($id) {
                try {
                    return new ObjectId($id);
                } catch (\Exception $e) {
                    return null;
                }
            }, $activeEmployeeIds)));
        }

        $wholesaler = $query->get();

        $features = $this->getfeatures();
        if (empty($features)) {
            return redirect('MyDashboard')->with('error', "Something went wrong");
        }

        return view('templates.myadmin.employee')->with([
            'customers' => $wholesaler,
            'allfeatures' => $features
        ]);
    }


    public function edit_employee($id)
    {
        $wholesalers = UserRegister::where('_id', '=', $id)->where('Register_as', '=', 'Employee')->get();
        $emp = Employee::where('employee_auto_id', '=', $id)->get();
        $features = $this->getfeatures();
        if (empty($features)) {
            return redirect('MyDashboard')->with('error', "Something went wrong");
        } else {
            return view('templates.myadmin.edit_employee')->with(['wholesalers' => $wholesalers, 'emp_details' => $emp, 'allfeatures' => $features]);
        }
    }

    public function update_employee(Request $request)
    {
        $employee = UserRegister::find($request->input('id'));
        $employee->status = $request->input('status');
        $employee->save();
        return redirect('employee')->with('success', 'Updated Successfully');
    }
}
