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
use Illuminate\Support\Facades\Session;

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
            'admin_username' => 'required',
            'contact' => 'required',
            'email' => 'required'
        ], [
            'name.required' => 'Please enter admin name',
            'admin_username.required' => 'Please enter username',
            'contact.required' => 'Please enter contact number',
            'email.required' => 'Please enter email-id'
        ]);

        $get_data = Admin::where('_id', $sid)->get();

        if ($get_data->isNotEmpty()) {

            DB::table('admin_login')
                ->where('_id', $sid)
                ->update(['name' => $request->input('name'), 'username' => $request->input('admin_username'), 'contact' => $request->input('contact'), 'email' => $request->input('email')]);

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

    public function home()
    {
        $vid = Session::get('AccessToken');

        $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        $order_date = $date->format('Y-m-d');

        $wholesalers = UserRegister::where('Register_as', '=', 'Employer')->get();
        $wholesaler_count = count($wholesalers);

        $employee = UserRegister::where('Register_as', '=', 'Employee')->get();
        $employee_count = count($employee);

        $enquiry = EcommPlans::get();
        $enquiry_count = count($enquiry);


        //   $features = $this->getfeatures();
        //   if(empty($features)){
        //       return redirect('MyDashboard')->with( 'error', "Something went wrong");
        //   }
        //   else{

        return view('templates.myadmin.index')->with(['wholesaler_count' => $wholesaler_count, 'employee_count' => $employee_count, 'enquiry_count' => $enquiry_count]);
        // }
    }
}
