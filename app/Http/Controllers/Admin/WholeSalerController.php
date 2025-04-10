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

            if ($range === 'weekly') {
                // Parse the full date stdd($date->startOfDay());
                $date = Carbon::parse($period);
                $query->whereBetween('created_at', [
                    new \MongoDB\BSON\UTCDateTime($date->startOfDay()),
                    new \MongoDB\BSON\UTCDateTime($date->endOfDay())
                ]);
            } else {
                // Use $dateToString for monthly/yearly filtering
                switch ($range) {
                    case 'monthly':
                        $format = "%b"; // e.g., "Apr"
                        break;

                    case 'yearly':
                        $format = "%Y"; // e.g., "2025"
                        break;

                    default:
                        $format = null;
                }

                if ($format) {
                    $query = $query->whereRaw([
                        '$expr' => [
                            '$eq' => [
                                ['$dateToString' => ['format' => $format, 'date' => '$created_at']],
                                $period
                            ]
                        ]
                    ]);
                }
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

            if ($range === 'weekly') {
                // Parse the full date string like "2025-04-07"
                $date = Carbon::parse($period);
                $query->whereBetween('created_at', [
                    new \MongoDB\BSON\UTCDateTime($date->startOfDay()),
                    new \MongoDB\BSON\UTCDateTime($date->endOfDay())
                ]);
            } else {
                // Use $dateToString for monthly/yearly filtering
                switch ($range) {
                    case 'monthly':
                        $format = "%b"; // e.g., "Apr"
                        break;

                    case 'yearly':
                        $format = "%Y"; // e.g., "2025"
                        break;

                    default:
                        $format = null;
                }

                if ($format) {
                    $query = $query->whereRaw([
                        '$expr' => [
                            '$eq' => [
                                ['$dateToString' => ['format' => $format, 'date' => '$created_at']],
                                $period
                            ]
                        ]
                    ]);
                }
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
