<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use DateTime;
use App\Admin;
use App\Orders;
use App\Product;
use App\Uorders;
use DateTimeZone;
use App\EcommPlans;
use App\MainCategory;
use App\UserRegister;
use App\Traits\Features;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subject;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Employee;

class AdminController extends Controller
{
    use Features;
    public function index()
    {
        $admin = Admin::get();

        $features = $this->getfeatures();
        if (empty($features)) {
            return redirect('MyDashboard')->with('error', "Something went wrong");
        } else {
            return view('templates.myadmin.profile')->with(['profiles' => $admin, 'allfeatures' => $features]);
        }
    }

    public function register()
    {
        $admin = new Admin();

        $admin->username = 'ADMIN2025';
        $admin->password = password_hash('ADMIN2025', PASSWORD_BCRYPT);
        $admin->save();

        return $admin;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|min:4|regex:/^([A-Za-z0-9]+)$/',
            'password' => 'required|min:4|regex:/^([A-Za-z0-9]+)$/'
        ]);

        $uname = $request->get('username');
        $pwd =  $request->get('password');

        $checkuname = Admin::where('username', '=', $uname)->get();

        if ($checkuname === null) {
            return redirect('MyDashboard')->with('error', "Username not exists , Please try again.");
        } else {
            $datapwd = Admin::select('password', '_id')->where('username', $uname)->get();

            if ($datapwd->isNotEmpty()) {
                foreach ($datapwd as $dpwd) {
                    $dbpwd = $dpwd->password;
                    $id = $dpwd->_id;
                }
            } else {

                return redirect('MyDashboard')->with('error', " Invalid Credentials , Please try again.");
            }


            if (password_verify($pwd, $dbpwd)) {

                Session::put('AccessToken', $id);
                return redirect('home');
            } else {
                return redirect('MyDashboard')->with('error', "Invalid Credentials , Please try again.");
            }
        }
    }

    public function add_account()
    {

        $account = Admin::get();

        $features = $this->getfeatures();
        if (empty($features)) {
            return redirect('MyDashboard')->with('error', "Something went wrong");
        } else {

            return view('templates.myadmin.account')->with(['accounts' => $account, 'allfeatures' => $features]);
        }
    }

    public function account()
    {

        $features = $this->getfeatures();
        if (empty($features)) {
            return redirect('MyDashboard')->with('error', "Something went wrong");
        } else {
            return view('templates.myadmin.account')->with(['allfeatures' => $features]);
        }
    }
    public function update(Request $request)
    {
        $sid =  Session::get('AccessToken');

        $this->validate($request, [
            'oldp' => 'required|min:4|regex:/^([A-Za-z0-9]+)$/',
            'newp' => 'required|min:4|regex:/^([A-Za-z0-9]+)$/'
        ], [
            'oldp.required' => 'Please enter old password',
            'newp.required' => 'Please enter new password',
        ]);

        $oldp =  $request->get('oldp');
        $newp =  $request->get('newp');
        $npassword = password_hash($newp, PASSWORD_BCRYPT);

        $datapwd = Admin::select('password')->where('_id', $sid)->get();
        foreach ($datapwd as $dpwd) {
            $dbpwd = $dpwd->password;
        }

        if (password_verify($oldp, $dbpwd)) {
            DB::table('admin_login')
                ->where('_id', $sid)
                ->update(['password' => $npassword]);


            $features = $this->getfeatures();
            if (empty($features)) {
                return redirect('MyDashboard')->with('error', "Something went wrong");
            } else {
                return redirect('account')->with('error', "Password Changed Successfully");
            }
        }
    }

    public function update_profile(Request $request)
    {

        $sid =  Session::get('AccessToken');

        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'contact' => 'required',
            'email' => 'required'
        ], [
            'name.required' => 'Please enter admin name',
            'username.required' => 'Please enter username',
            'contact.required' => 'Please enter contact number',
            'email.required' => 'Please enter email-id'
        ]);

        $get_data = Admin::where('_id', $sid)->get();

        if ($get_data->isNotEmpty()) {

            DB::table('admin_login')
                ->where('_id', $sid)
                ->update(['name' => $request->input('name'), 'username' => $request->input('username'), 'contact' => $request->input('contact'), 'email' => $request->input('email')]);

            return redirect('profile')->with('success', "Profile has been Changed Successfully");
        } else {
            return redirect('profile')->with('error', "Something went wrong, Please try again.");
        }
    }

    public function logout(Request $request)
    {
        Session::forget(Session::get('AccessToken'));
        Session::flush();
        $request->session()->flush();
        return redirect('MyDashboard')->with('success', 'Successfully Logged Out');
    }

    // public function home()
    // {
    //     $vid = Session::get('AccessToken');

    //     $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
    //     $order_date = $date->format('Y-m-d');

    //     $wholesalers = UserRegister::where('Register_as', '=', 'Employer')->get();
    //     $wholesaler_count = count($wholesalers);

    //     $employee = UserRegister::where('Register_as', '=', 'Employee')->get();
    //     $employee_count = count($employee);

    //     $subject_count = Subject::count();

    //     $enquiry = EcommPlans::get();
    //     $enquiry_count = count($enquiry);


    //     //   $features = $this->getfeatures();
    //     //   if(empty($features)){
    //     //       return redirect('MyDashboard')->with( 'error', "Something went wrong");
    //     //   }
    //     //   else{

    //     return view('templates.myadmin.index')->with(['wholesaler_count' => $wholesaler_count, 'employee_count' =>
    //     $employee_count, 'enquiry_count' => $enquiry_count, 'subject_count' => $subject_count]);
    //     // }
    // }



    public function home()
    {
        $wholesaler_count = UserRegister::where('Register_as', '=', 'Employer')->count();
        $employee_count = UserRegister::where('Register_as', '=', 'Employee')->count();

        $enquiry_count = EcommPlans::count();

        // Fetching all relevant data for charts
        $employers = UserRegister::where('Register_as', 'Employer')->get(['created_at']);
        $employees = UserRegister::where('Register_as', 'Employee')->get(['created_at']);
        $employeesdetails = Employee::all();

        $today = Carbon::today();
        $active_users_today_count = 0;

        foreach ($employeesdetails as $emp) {
            $parts = explode(',', $emp->last_seen_datetime);
            if (count($parts) < 2) continue;
            $datePart = trim($parts[1]); 
            try {
                $carbonDate = Carbon::createFromFormat('d M Y', $datePart);
                if ($carbonDate->isSameDay($today)) {
                    $active_users_today_count++;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        // Chart Data Arrays
        $weekly = [
            'labels' => [],
            'employers' => [],
            'employees' => []
        ];

        $monthly = [
            'labels' => [],
            'employers' => [],
            'employees' => []
        ];

        $yearly = [
            'labels' => [],
            'employers' => [],
            'employees' => []
        ];

        // Initialize Weekly Labels (last 7 days)
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $weekly['labels'][] = $date;
            $weekly['employers'][$date] = 0;
            $weekly['employees'][$date] = 0;
        }
        // Initialize Monthly Labels (last 4 months)
        for ($i = 3; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('M');
            $monthly['labels'][] = $month;
            $monthly['employers'][$month] = 0;
            $monthly['employees'][$month] = 0;
        }

        // Initialize Yearly Labels (last 3 years)
        for ($i = 2; $i >= 0; $i--) {
            $year = Carbon::now()->subYears($i)->format('Y');
            $yearly['labels'][] = $year;
            $yearly['employers'][$year] = 0;
            $yearly['employees'][$year] = 0;
        }

        // Parse Employers
        foreach ($employers as $emp) {
            $created = Carbon::parse($emp->created_at);

            // Weekly
            $day = $created->format('Y-m-d'); // ✅ Full date
            if (in_array($day, $weekly['labels'])) {
                $weekly['employers'][$day]++;
            }

            // Monthly
            $month = $created->format('M');
            if (in_array($month, $monthly['labels'])) {
                $monthly['employers'][$month]++;
            }

            // Yearly
            $year = $created->format('Y');
            if (in_array($year, $yearly['labels'])) {
                $yearly['employers'][$year]++;
            }
        }

        foreach ($employees as $emp) {
            $created = Carbon::parse($emp->created_at);

            // Weekly
            $day = $created->format('Y-m-d'); // ✅ Full date
            if (in_array($day, $weekly['labels'])) {
                $weekly['employees'][$day]++;
            }

            // Monthly
            $month = $created->format('M');
            if (in_array($month, $monthly['labels'])) {
                $monthly['employees'][$month]++;
            }

            // Yearly
            $year = $created->format('Y');
            if (in_array($year, $yearly['labels'])) {
                $yearly['employees'][$year]++;
            }
        }

        // Prepare compact chartData for JS
        $chartData = [
            'weekly' => [
                'labels' => $weekly['labels'],
                'employers' => array_values($weekly['employers']),
                'employees' => array_values($weekly['employees'])
            ],
            'monthly' => [
                'labels' => $monthly['labels'],
                'employers' => array_values($monthly['employers']),
                'employees' => array_values($monthly['employees'])
            ],
            'yearly' => [
                'labels' => $yearly['labels'],
                'employers' => array_values($yearly['employers']),
                'employees' => array_values($yearly['employees'])
            ]
        ];

        return view('templates.myadmin.index')->with([
            'wholesaler_count' => $wholesaler_count,
            'employee_count' => $employee_count,
            'enquiry_count' => $enquiry_count,
            'active_users_today_count' => $active_users_today_count,
            'chartData' => $chartData
        ]);
    }
}