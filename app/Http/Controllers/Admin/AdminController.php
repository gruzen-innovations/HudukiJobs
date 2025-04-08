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

        $employers = UserRegister::where('Register_as', 'Employer')->get(['updated_at']);
        $employees = Employee::all(['last_seen_datetime']);

        $today = Carbon::today();
        $active_users_today_count = 0;

        foreach ($employees as $emp) {
            $parts = explode(',', $emp->last_seen_datetime);
            if (count($parts) < 1) continue;
            $datePart = trim($parts[0]);
            try {
                $carbonDate = Carbon::createFromFormat(
                    'd-m-Y',
                    $datePart
                );
                if ($carbonDate->isSameDay($today)) {
                    $active_users_today_count++;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        // === WEEKLY (Last 7 Days) ===
        $weekly = [
            'labels' => [],
            'employers' => [],
            'employees' => []
        ];

        $weeklyDateKeys = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $key = $date->format('Y-m-d');
            $weekly['labels'][] = $date->format('D'); // Mon, Tue...
            $weekly['employers'][$key] = 0;
            $weekly['employees'][$key] = 0;
            $weeklyDateKeys[] = $key;
        }

        // === MONTHLY (Last 4 Months) ===
        $monthly = [
            'labels' => [],
            'employers' => [],
            'employees' => []
        ];
        for ($i = 3; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('M');
            $monthly['labels'][] = $month;
            $monthly['employers'][$month] = 0;
            $monthly['employees'][$month] = 0;
        }

        // === YEARLY (Last 3 Years) ===
        $yearly = [
            'labels' => [],
            'employers' => [],
            'employees' => []
        ];
        for ($i = 2; $i >= 0; $i--) {
            $year = Carbon::now()->subYears($i)->format('Y');
            $yearly['labels'][] = $year;
            $yearly['employers'][$year] = 0;
            $yearly['employees'][$year] = 0;
        }

        // === EMPLOYERS PARSING ===
        foreach ($employers as $emp) {
            $updated = Carbon::parse($emp->updated_at);
            $dayKey = $updated->format('Y-m-d');

            // Weekly
            if (array_key_exists($dayKey, $weekly['employers'])) {
                $weekly['employers'][$dayKey]++;
            }

            // Monthly
            $month = $updated->format('M');
            if (array_key_exists($month, $monthly['employers'])) {
                $monthly['employers'][$month]++;
            }

            // Yearly
            $year = $updated->format('Y');
            if (array_key_exists($year, $yearly['employers'])) {
                $yearly['employers'][$year]++;
            }
        }

        // === EMPLOYEES PARSING ===
        foreach ($employees as $emp) {
            $parts = explode(',', $emp->last_seen_datetime);
            if (count($parts) < 1) continue;
            $datePart = trim($parts[0]);
            try {
                $carbonDate = Carbon::createFromFormat(
                    'd-m-Y',
                    $datePart
                );
                $dayKey = $carbonDate->format('Y-m-d');

                // Weekly
                if (array_key_exists($dayKey, $weekly['employees'])) {
                    $weekly['employees'][$dayKey]++;
                }

                // Monthly
                $month = $carbonDate->format('M');
                if (array_key_exists($month, $monthly['employees'])) {
                    $monthly['employees'][$month]++;
                }

                // Yearly
                $year = $carbonDate->format('Y');
                if (array_key_exists($year, $yearly['employees'])) {
                    $yearly['employees'][$year]++;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        // === Convert Weekly Keys to Labels (Mon, Tue...) ===
        $weekly_labels = [];
        $weekly_employers = [];
        $weekly_employees = [];

        foreach ($weekly['employers'] as $date => $count) {
            $weekly_labels[] = Carbon::parse($date)->format('D');
            $weekly_employers[] = $count;
            $weekly_employees[] = $weekly['employees'][$date];
        }

        // === Prepare Chart Data for JS ===
        $chartData = [
            'weekly' => [
                'labels' => $weekly_labels,
                'employers' => $weekly_employers,
                'employees' => $weekly_employees
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
