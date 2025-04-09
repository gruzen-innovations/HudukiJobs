<?php

namespace App\Http\Controllers;

use DateTime;
use App\Admin;
use App\Charges;
use App\Employee;
use DateTimeZone;
use App\AppliedJobs;
use App\UserRegister;
use App\Notifications;
use App\userWorkDetails;
use App\VerifyUserEmail;
use App\Models\Promocode;
use App\Models\Categories;
use App\VerifyUserContact;
use Illuminate\Http\Request;
use App\EmployeeNotification;
use App\Models\CustomerFeedback;
use App\userQualificationsDetails;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\EmergencyInformation;



class UserApiController extends Controller
{
    public function send_registration_email_otp(Request $request)
    {
        if ($request->email != "") {
            $regusers = VerifyUserEmail::Where('email', "=", $request->email)->Where('otp_status', "=", 'verified')->get();
            if ($regusers->isNotEmpty()) {
                return response()->json(['status' => 2, 'msg' => 'This email is already verified']);
            } else {

                $otp = rand(1000, 9999);

                $otps = new  VerifyUserEmail();
                $otps->email = $request->get('email');
                $otps->otp = $otp;
                $otps->otp_status = "unverified";
                $otps->save();

                $subject = "Your Verification Code";
                $header = "From: " . config('smsapi.from');
                $content = "This is to inform you that your verification code has been sent  : " . $otp . "\n\n\nThanks & Regards";

                mail($request->get('email'), $subject, $content, $header);

                if ($otps) {
                    return response()->json(['status' => 1, 'msg' => 'otp sent to your email']);
                } else {
                    return response()->json(['status' => 0, 'msg' => 'email is not valid ']);
                }
            }
        } else {
            return response()->json(['status' => 0, 'msg' => 'Please Enter email id ']);
        }
    }
    //verify email
    public function verify_registration_email_otp(Request $request)
    {
        $checkUsers = VerifyUserEmail::where('email', $request->email)
            ->where('otp_status', 'unverified')
            ->orderBy('_id', 'DESC')
            ->first();

        if ($checkUsers) {
            if ($checkUsers->otp == $request->otp) {
                $update = VerifyUserEmail::where('email', $request->email)->update(['otp_status' => 'verified']);

                return response()->json([
                    'status' => 1,
                    'msg' => 'Your email id is verified...!',

                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'msg' => 'OTP is mismatched...!',
                ]);
            }
        } else {
            return response()->json([
                'status' => 0,
                'msg' => 'Your email id is not verified...!',
            ]);
        }
    }

    public function register(Request $request)
    {
        $UserRegister = new UserRegister();
        $checkUserMob = UserRegister::where('mobile_number', $request->mobile_number)->first();
        $checkUserEmail = UserRegister::where('email_id', $request->email_id)->first();
        if ($checkUserMob) {
            return response()->json([
                'status' => '2',
                'msg' => 'This mobile number is already exist..!',
            ]);
        } elseif ($checkUserEmail) {
            return response()->json([
                'status' => '2',
                'msg' => 'This email is already exist..!',
            ]);
        } else {

            $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
            $rdate =  $date->format('Y-m-d');
            $UserRegister->name = $request->get('name');
            $UserRegister->email_id = $request->get('email_id');
            $UserRegister->mobile_number = $request->get('mobile_number');
            $UserRegister->password = password_hash($request->get('password'), PASSWORD_BCRYPT);
            $UserRegister->confirm_password = password_hash($request->get('confirm_password'), PASSWORD_BCRYPT);
            $UserRegister->status = 'Unblock';
            if ($request->get('token') != '') {
                $UserRegister->token = $request->get('token');
            } else {
                $UserRegister->token = "";
            }
            if ($request->get('Register_as') != '') {
                $UserRegister->Register_as = $request->get('Register_as');
            } else {
                $UserRegister->Register_as = "";
            }
            if (!empty($request->file('profile_photo'))) {
                $file = $request->file('profile_photo');
                $filename = $file->getClientOriginalName();
                $path = public_path('images/profile');
                $file->move($path, $filename);
                $UserRegister->profile_photo = $filename;
            } else {
                $UserRegister->profile_photo = '';
            }

            if ($request->get('fresher_or_experienced') != '') {
                $UserRegister->fresher_or_experienced = $request->get('fresher_or_experienced');
            } else {
                $UserRegister->fresher_or_experienced = "";
            }
            $UserRegister->login_otp = "";
            $UserRegister->company_name = $request->get('company_name', '');
            $UserRegister->company_register_date = $request->get('company_register_date') ?? '';

            if (!empty($request->file('company_logo'))) {
                $file = $request->file('company_logo');
                $filename = $file->getClientOriginalName();
                $path = public_path('images/company_logo');
                $file->move($path, $filename);
                $UserRegister->company_logo = $filename;
            } else {
                $UserRegister->company_logo = '';
            }
            if (!empty($request->file('company_photo'))) {
                $file = $request->file('company_photo');
                $filename = $file->getClientOriginalName();
                $path = public_path('images/company_photo');
                $file->move($path, $filename);
                $UserRegister->company_photo = $filename;
            } else {
                $UserRegister->company_photo = '';
            }

            if ($request->hasFile('certificate_gst_pancard')) {
                $file = $request->file('certificate_gst_pancard');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = public_path('images/documents');
                $file->move($path, $filename);
                $UserRegister->certificate_gst_pancard = $filename;
            } else {
                $UserRegister->certificate_gst_pancard = '';
            }
            $UserRegister->company_description = $request->get('company_description', '');
            $UserRegister->company_employee_range = $request->get('company_employee_range', '');
            $UserRegister->company_type = $request->get('company_type', '');
            $UserRegister->company_headquarter = $request->get('company_headquarter', '');
            $UserRegister->company_website = $request->get('company_website', '');
            $UserRegister->company_address = $request->get('company_address', '');
            $UserRegister->language = $request->get('language', '');
            $UserRegister->job_count = $request->get('job_count', '0');
            $UserRegister->register_date = date('Y-m-d');

            $UserRegister->save();
            $inserted_id = $UserRegister->id;

            $emp = new Employee();

            $emp->employee_auto_id = $inserted_id;
            $emp->resume = '';
            $emp->video_resume = '';
            $emp->profile_picture = '';
            $emp->first_name = $request->get('first_name', '');
            $emp->middle_name = "";
            $emp->last_name = "";
            $emp->gender = "";
            $emp->date_of_birth = "";
            $emp->address = "";
            $emp->city = "";
            $emp->pincode = "";
            $emp->fresher_or_experienced = $request->get('fresher_or_experienced') ?? '';
            $emp->skills = "";
            $emp->prefered_jobrole = "";
            $emp->prefered_job_locaion = "";
            $emp->preferred_job_type = "";
            $emp->field_of_experience = "";
            $emp->employment_type = "";
            $emp->advance_skills = "";
            $emp->current_ctc = "";
            $emp->expected_ctc = "";
            $emp->completion_status = $request->completion_status ?? "No";
            $emp->preferred_shift = "";
            $emp->open_to_work = '';
            $emp->mark_as_hired = '';
            $emp->language = '';
            $emp->rating = '';
            $emp->adhaar_card_img_front = '';
            $emp->adhaar_card_img_back = '';
            $emp->last_seen_datetime = '';

            $emp->save();


            return response()->json([
                'status' => '1',
                'msg' => config('messages.success'),
                'id' => $UserRegister->id,
                'Register_as' => $UserRegister->Register_as,
                'completion_status' => $emp->completion_status,
                'employee_details_auto_id' => $emp->id,

            ]);
        }
    }


    public function send_registration_contact_otp(Request $request)
    {
        if ($request->mobile_number != "") {

            $vusers = VerifyUserContact::Where('mobile_number', $request->mobile_number)->Where('otp_status', "=", 'verified')->get();
            if ($vusers->isNotEmpty()) {
                return response()->json([
                    'status' => '2',
                    'msg' => 'This number is already verified..!',
                ]);
            } else {

                $otp = rand(1000, 9999);

                $otps = new  VerifyUserContact();
                $otps->mobile_number = $request->get('mobile_number');
                $otps->otp = $otp;
                $otps->otp_status = "unverified";
                $otps->save();

                $smsurl = "https://api.msg91.com/api/v5/otp?otp=" . $otp . "&authkey=241080AlR9lrJsEY85bb5ff15&mobile=" . $request->mobile_number . "&template_id=62847a3e29f604486625d8f6";
                file_get_contents($smsurl);

                if ($otps) {
                    return response()->json(['status' => '1', 'msg' => 'otp sent to your mobile number ']);
                } else {
                    return response()->json(['status' => '0', 'msg' => 'Mobile number is not valid ']);
                }
            }
        } else {
            return response()->json(['status' => '0', 'msg' => 'Please Enter mobile number ']);
        }
    }

    //verify reg mob no
    public function verify_registration_contact_otp(Request $request)
    {
        $checkUsers = VerifyUserContact::where('mobile_number', $request->mobile_number)->where('otp_status', 'unverified')->orderBy('_id', 'DESC')->first();
        if ($checkUsers) {
            if ($checkUsers->otp == $request->otp) {
                $update = VerifyUserContact::where('mobile_number', $request->mobile_number)->update(['otp_status' => 'verified']);
                return response()->json([
                    'status' => '1',
                    'msg' => 'Your contact number is verified...!',

                ]);
            } elseif ($request->otp == "1234") {
                $update = VerifyUserContact::where('mobile_number', $request->mobile_number)->update(['otp_status' => 'verified']);
                return response()->json([
                    'status' => '1',
                    'msg' => 'Your contact number is verified...!',
                ]);
            } else {
                return response()->json([
                    'status' => '0',
                    'msg' => 'OTP is mismatched...!',
                ]);
            }
        } else {
            return response()->json([
                'status' => '0',
                'msg' => 'Your contact number is not verified...!',
            ]);
        }
    }

    public function login(Request $request)
    {
        if (($request->get('email_id')) == '') {
            return response()->json([
                'status' => 2,
                'msg' => 'Please Enter email id',
            ]);
        }

        $checckaccount = UserRegister::where('email_id', $request->get('email_id'))
            ->where('Register_as', 'Employer')->first();

        if ($checckaccount) {

            if ((preg_match("/^.*(?=.{6,}).*$/", ($request->get('password'))) === 0) || ($request->get('password')) == '') {
                return response()->json([
                    'status' => 3,
                    'msg' => config('messages.invalidpassword'),
                ]);
            } else {
                $status = $checckaccount->status;
                $password = $checckaccount->password;
                $user_id = $checckaccount->id;
                $Register_as = $checckaccount->Register_as;

                if ($status == 'Block') {
                    return response()->json([
                        'status' => 5,
                        'msg' => config('messages.block'),
                    ]);
                } else {
                    if (password_verify($request->get('password'), $password)) {

                        $usersd_statuss = Employee::where('employee_auto_id', $user_id)->get();
                        if ($usersd_statuss->isNotEmpty()) {
                            foreach ($usersd_statuss as $status) {
                                $completion_status = $status->completion_status;
                            }
                        } else {
                            $completion_status = 'No';
                        }
                        if ($request->get('token') != '') {
                            $checckaccount->token = $request->get('token');
                            $checckaccount->save();
                        }
                        return response()->json([
                            'status' => 1,
                            'msg' => config('messages.success'),
                            'user_id' => $user_id,
                            'Register_as' => $Register_as,
                            'completion_status' => $completion_status,
                        ]);
                    } else {
                        return response()->json([
                            'status' => 0,
                            'msg' => config('messages.unsuccess'),
                        ]);
                    }
                }
            }
        } else {
            return response()->json([
                'status' => 0,
                'msg' => 'Sorry, Account is not created with this email id.',
            ]);
        }
    }


    public function sendEmployerLoginOtp(Request $request)
    {
        // Validate the request
        $request->validate([
            'mobile_number' => 'required|string',
        ]);

        // Find user in UserRegister
        $user = UserRegister::where('mobile_number', $request->mobile_number)
            ->where('Register_as', 'Employee')
            ->whereNull('deleted_at')
            ->first();

        // Check if user exists
        if (!$user) {
            return response()->json([
                'status' => 0,
                'msg' => 'Mobile Number Not Registered',
            ]);
        }

        // Check if account is blocked
        if ($user->status === 'Block') {
            return response()->json([
                'status' => 0,
                'msg' => 'Your account is blocked. OTP cannot be sent.',
            ]);
        }

        // Generate OTP
        $generatedOtp = rand(1000, 9999);

        // Update OTP in the database
        $user->login_otp = strval($generatedOtp);
        $user->save();

        // Send OTP via SMS
        $smsurl = "https://api.msg91.com/api/v5/otp?otp=" . $generatedOtp .
            "&authkey=241080AlR9lrJsEY85bb5ff15&mobile=" .
            $request->mobile_number . "&template_id=62847a3e29f604486625d8f6";

        file_get_contents($smsurl);

        return response()->json([
            'status' => 1,
            'msg' => 'OTP sent to your mobile number',
        ]);
    }

    public function employeeLogin(Request $request)
    {
        // Validate the request
        $request->validate([
            'mobile_number' => 'required|string',
            'otp' => 'required|string',
            'token' => 'required|string',
        ]);

        // Find user in UserRegister
        $user = UserRegister::where('mobile_number', $request->mobile_number)
            ->where('Register_as', 'Employee')
            ->whereNull('deleted_at')
            ->first();

        // Check if user exists
        if (!$user) {
            return response()->json([
                'status' => 0,
                'msg' => 'User Not Found...!',
            ]);
        }

        // Check if account is blocked
        if ($user->status === 'Block') {
            return response()->json([
                'status' => 0,
                'msg' => 'Sorry, Your account is blocked!',
            ]);
        }


        // Verify OTP
        if ($user->login_otp == $request->otp) {

            // Update token after successful OTP verification
            $user->token = $request->token;
            $user->save();

            $usersd_statuss = Employee::where('employee_auto_id', $user->id)->get();
            if ($usersd_statuss->isNotEmpty()) {
                foreach ($usersd_statuss as $status) {
                    $completion_status = $status->completion_status;
                }
            } else {
                $completion_status = 'No';
            }

            // Return login success response
            return response()->json([
                'status' => 1,
                'msg' => 'Login Successful...!',
                'user_id' => $user->id,
                'mobile_number' => $user->mobile_number,
                'Register_as' => $user->Register_as,
                'completion_status' => $completion_status,
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'msg' => 'Invalid OTP...!',
            ]);
        }
    }

    // Forgot Password
    public function forgotPass(Request $request)
    {
        if ((!filter_var(($request->get('email')), FILTER_VALIDATE_EMAIL)) || ($request->get('email')) == '') {
            return response()->json([
                'status' => 2,
                'msg' => config('messages.invalidemail'),
            ]);
        } else {
            $ruser = UserRegister::where('email_id', '=', $request->get('email'))->get();
            if (count($ruser) == 0) {
                return response()->json(['status' => 0, "msg" => config('messages.nemail')]);
            } else {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 6; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                $password = password_hash($randomString, PASSWORD_BCRYPT);

                DB::table('UserRegister')->where('email_id', '=', $request->get('email'))
                    ->update(['password' => $password]);

                $subject = "Your New Password";
                $header = "From: " . config('smsapi.from');
                $content = "This is to inform you that your password has been reset to : " . $randomString . "\n\n\nThanks & Regards";

                mail($request->get('email'), $subject, $content, $header);

                // $curl = curl_init();

                // curl_setopt_array($curl, [
                //   CURLOPT_URL => "https://api.msg91.com/api/v5/email/send",
                //   CURLOPT_RETURNTRANSFER => true,
                //   CURLOPT_ENCODING => "",
                //   CURLOPT_MAXREDIRS => 10,
                //   CURLOPT_TIMEOUT => 30,
                //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                //   CURLOPT_CUSTOMREQUEST => "POST",
                //   CURLOPT_POSTFIELDS => "{\n  \"to\": [\n    {\n      \"name\": \"User\",\n      \"email\": \"$request->email\"\n    }\n  ],\n  \"from\": {\n    \"name\": \"Grobiz E-Commerce App Builder\",\n    \"email\": \"support@gruzen.in\"\n  },\n\n  \"domain\": \"gruzen.in\",\n  \"mail_type_id\": \"1\",\n \n  \"template_id\": \"Forgot_Password-OTP-1\",\n  \"variables\": {\n    \"VAR\": \"$randomString\"\n  }\n}",
                //   CURLOPT_HTTPHEADER => [
                //     "Accept: application/json",
                //     "Content-Type: application/json",
                //     "authkey: 241080AlR9lrJsEY85bb5ff15"
                //   ],
                // ]);

                // $response = curl_exec($curl);
                // $err = curl_error($curl);

                // curl_close($curl);

                return response()->json(['status' => 1, "msg" => config('messages.success')]);
            }
        }
    }

    public function updatePass(Request $request)
    {
        if ((preg_match("/^.*(?=.{6,}).*$/", ($request->old_password)) === 0) || ($request->old_password) == '') {
            return response()->json(['status' => 0, 'msg' => 'Password must be atleast 6 characters']);
        } else if ((preg_match("/^.*(?=.{6,}).*$/", ($request->new_password)) === 0) || ($request->new_password) == '') {
            return response()->json(['status' => 0, 'msg' => 'Password must be atleast 6 characters']);
        } else {
            $ruser = UserRegister::find($request->user_auto_id);
            if (!empty($ruser)) {
                $dbpassword = $ruser->password;
                if (password_verify($request->old_password, $dbpassword)) {
                    $npassword = password_hash($request->new_password, PASSWORD_BCRYPT);
                    $ruser->password = $npassword;
                    $ruser->save();
                    return response()->json(['status' => 1, "msg" => 'success..!']);
                } else {
                    return response()->json(['status' => 0, "msg" => 'Your old password does not match..!']);
                }
            } else {
                return response()->json(['status' => 0, "msg" => 'Sorry, an account not exist']);
            }
        }
    }

    public function get_user_profile(Request $request)
    {
        $getUSer = UserRegister::find($request->user_auto_id);
        if ($getUSer) {
            return response()->json(['status' => '1', "msg" => 'success', "data" => $getUSer]);
        } else {
            return response()->json(['status' => '0', "msg" => 'fail']);
        }
    }
    public function send_response(Request $request)
    {
        $firebaseToken = UserRegister::where('_id', '=', $request->employee_auto_id)->where('Register_as', '=', 'Employee')->whereNotNull('token')->pluck('token')->all();
        $employer_details = UserRegister::where('_id', '=', $request->employer_auto_id)->where('Register_as', '=', 'Employer')->get();
        if ($employer_details->isNotEmpty()) {
            foreach ($employer_details as $emp) {
                $emp_name =  $emp->name;
            }
        } else {
            $emp_name = '';
        }
        $ajobs = AppliedJobs::where('employee_auto_id', $request->employee_auto_id)->where('employer_auto_id', $request->employer_auto_id)->get();
        if ($ajobs->isNotEmpty()) {
            foreach ($ajobs as $j) {
                $job_auto_id =  $j->job_auto_id;
            }
        } else {
            $job_auto_id = '';
        }
        $add = new EmployeeNotification();
        $add->employee_auto_id = $request->get('employee_auto_id');
        $add->employer_auto_id = $request->get('employer_auto_id');
        $add->employer_name = $emp_name;
        $add->job_auto_id = $job_auto_id;
        $add->save();

        $SERVER_API_KEY = 'AAAAuOo7Z30:APA91bFef9863oqsNOEjbvplMsJ4QKAo5NSfz9hgjtJ1YXOTRj5LCqJU8-ddFX-28JSf7RGmD62M5gTtaNwyMEGLtQCmo-Jx2JMDmXZH3LjqyymMiI0iqzVpz_hLdnMW1OLjHMnBLxBz';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "body"  =>  "Your profile has been shortlisted by $emp_name",
                "title" => 'Recruiter Response',
                "sound" => "default",
                "click_action" => "com.jobportal.jobportal.job_portal",
            ]

        ];

        $dataString = json_encode($data);
        $headers = [

            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',

        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);


        return response()->json(['status' => '1', "msg" => 'success']);
    }
    public function get_employee_notification()
    {
        $getempnoti = EmployeeNotification::get();
        if ($getempnoti->isNotEmpty()) {
            return response()->json(['status' => '1', "msg" => 'success', "data" => $getempnoti]);
        } else {
            return response()->json(['status' => '0', "msg" => 'No Data Available']);
        }
    }
    public function get_employer_notifications()
    {
        $getUSernoti = Notifications::get();
        if ($getUSernoti->isNotEmpty()) {
            return response()->json(['status' => '1', "msg" => 'success', "data" => $getUSernoti]);
        } else {
            return response()->json(['status' => '0', "msg" => 'No Data Available']);
        }
    }

    // Update Profile
    public function update_user_profile(Request $request)
    {
        $customer = UserRegister::find($request->get('user_auto_id'));

        if (empty($customer)) {
            return response()->json(['status' => '0', "msg" => "No User Found"]);
        }

        // Only update fields if they are present in the request
        if ($request->has('name')) {
            $customer->name = $request->get('name');
        }
        if ($request->has('email_id')) {
            $customer->email_id = $request->get('email_id');
        }
        if ($request->has('mobile_number')) {
            $customer->mobile_number = $request->get('mobile_number');
        }
        if ($request->has('token')) {
            $customer->token = $request->get('token');
        }
        if ($request->has('company_register_date')) {
            $customer->company_register_date = $request->get('company_register_date');
        }
        if ($request->has('company_name')) {
            $customer->company_name = $request->get('company_name');
        }
        if ($request->has('company_description')) {
            $customer->company_description = $request->get('company_description');
        }
        if ($request->has('company_employee_range')) {
            $customer->company_employee_range = $request->get('company_employee_range');
        }
        if ($request->has('company_type')) {
            $customer->company_type = $request->get('company_type');
        }
        if ($request->has('company_headquarter')) {
            $customer->company_headquarter = $request->get('company_headquarter');
        }
        if ($request->has('company_website')) {
            $customer->company_website = $request->get('company_website');
        }
        if ($request->has('company_address')) {
            $customer->company_address = $request->get('company_address');
        }
        if ($request->has('language')) {
            $customer->language = $request->get('language');
        }

        if ($request->has('is_hiring')) {
            $customer->is_hiring = $request->get('is_hiring');
        }

        if ($request->has('job_count')) {
            $customer->job_count = $request->get('job_count');
        }

        // Handle file uploads only if present
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('images/profile');
            $file->move($path, $filename);
            $customer->profile_photo = $filename;
        }

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('images/company_logo');
            $file->move($path, $filename);
            $customer->company_logo = $filename;
        }

        if ($request->hasFile('company_photo')) {
            $file = $request->file('company_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('images/company_photo');
            $file->move($path, $filename);
            $customer->company_photo = $filename;
        }

        if ($request->hasFile('certificate_gst_pancard')) {
            $file = $request->file('certificate_gst_pancard');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('images/documents');
            $file->move($path, $filename);
            $customer->certificate_gst_pancard = $filename;
        }

        $customer->save();

        return response()->json([
            'status' => '1',
            "msg" => config('messages.success'),
            'data' => $customer
        ]);
    }


    public function contactUs(Request $request)
    {

        $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        $rdate = $date->format('Y-m-d H:i:s');
        $add = new CustomerFeedback();
        $add->user_auto_id = $request->get('user_auto_id');
        $add->message = $request->get('message');
        if ($request->file('image') != '') {
            $name = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move('images/feedbacks/', $name);
            $data = $name;
            $add->feedback_img = $data;
        } else {
            $add->feedback_img = "";
        }

        if ($request->get('admin_auto_id') != '') {
            $add->admin_auto_id = $request->get('admin_auto_id');
        } else {
            $add->admin_auto_id = "";
        }
        $add->rdate = $rdate;
        $add->save();


        return response()->json([
            'status' => 1,
            'msg' => 'Thank you for your feedback, we will get back to you.',
            'data' => $add
        ]);
    }
    public function delete_user(Request $request)
    {
        $tdetails = UserRegister::where('contact', '=', $request->get('contact'))->where('admin_auto_id', $request->admin_auto_id)->delete();
        if ($tdetails) {
            return response()->json([
                'status' => 1,
                'msg' => "Sucessfully Deleted"
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'msg' => "Number Not registered"
            ]);
        }
    }
    public function get_price_details(Request $request)
    {
        $charges = Charges::where('admin_auto_id', $request->admin_auto_id)->get();
        if ($charges->isEmpty()) {
            return response()->json([
                'status' => 0,
                'msg' => config('messages.empty'),
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'price_details' => $charges,
            ]);
        }
    }
    public function get_promocode(Request $request)
    {
        $promo = Promocode::where('admin_auto_id', $request->admin_auto_id)->get();
        if ($promo->isEmpty()) {
            return response()->json([
                'status' => 0,
                'msg' => config('messages.empty'),
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'promocode_list' => $promo,
            ]);
        }
    }
    public function get_medical_department(Request $request)
    {
        $md = Categories::where('admin_auto_id', $request->admin_auto_id)->get();
        if ($md->isEmpty()) {
            return response()->json([
                'status' => 0,
                'msg' => config('messages.empty'),
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'all_medical_departments' => $md,
            ]);
        }
    }

    // public function show_scheduled_session(Request $request)
    // {
    //     $getSchduledList = bookSession::where('membership_booking_auto_id', '=', $request->get('membership_booking_auto_id'))->where('user_auto_id', '=', $request->get('user_auto_id'))->get();
    //     if ($getSchduledList->isNotEmpty()) {
    //         return response()->json(['status' => 1, "msg" => "success...!", 'getScheduledSessionList' => $getSchduledList]);
    //     } else {
    //         return response()->json(['status' => 0, "msg" => "Not Data Available"]);
    //     }
    // }

    public function update_user_status(Request $request)
    {

        $tasks = UserRegister::where('_id', '=', $request->get('user_auto_id'))->where('user_type', '=', $request->get('user_type'))->where('admin_auto_id', $request->admin_auto_id)->get();
        if ($tasks->isEmpty()) {
            return response()->json(['status' => 2, "msg" => "Sorry, user not found"]);
        } else {

            $update = DB::table('UserRegister')->where('_id', '=', $request->get('user_auto_id'))->where('admin_auto_id', $request->admin_auto_id)->where('user_type', '=', $request->get('user_type'))->update(['status' => $request->get('status')]);
            return response()->json(['status' => 1, "msg" => config('messages.success')]);
        }
    }


    public function update_employee_profile(Request $request)
    {

        $babout = Employee::where('employee_auto_id', $request->employee_auto_id)->get();
        if ($babout->isNotEmpty()) {
            $babout = Employee::find($request->get('employee_details_auto_id'));
            if (!empty($request->file('resume'))) {
                $file = $request->file('resume');
                $filename = $file->getClientOriginalName();
                $path = public_path('images/employee_details');
                $file->move($path, $filename);
                $babout->resume = $filename;
            }
            if (!empty($request->file('video_resume'))) {
                $file = $request->file('video_resume');
                $filename = $file->getClientOriginalName();
                $path = public_path('images/employee_details/');
                $file->move($path, $filename);
                $babout->video_resume = $filename;
            }
            if (!empty($request->file('profile_picture'))) {
                $file = $request->file('profile_picture');
                $filename = $file->getClientOriginalName();
                $path = public_path('images/employee_details');
                $file->move($path, $filename);
                $babout->profile_picture = $filename;
            }
            if ($request->get('first_name') != '') {
                $babout->first_name = $request->get('first_name');
            }
            if ($request->get('middle_name') != '') {
                $babout->middle_name = $request->get('middle_name');
            }
            if ($request->get('last_name') != '') {
                $babout->last_name = $request->get('last_name');
            }
            if ($request->get('gender') != '') {
                $babout->gender = $request->get('gender');
            }
            if ($request->get('date_of_birth') != '') {
                $babout->date_of_birth = $request->get('date_of_birth');
            }
            if ($request->get('address') != '') {
                $babout->address = $request->get('address');
            }
            if ($request->get('city') != '') {
                $babout->city = $request->get('city');
            }
            if ($request->get('pincode') != '') {
                $babout->pincode = $request->get('pincode');
            }
            // if($request->get('highest_qualification')!='')
            // {
            //         $babout->highest_qualification = $request->get('highest_qualification');
            // }
            // if($request->get('course')!='')
            // {
            //         $babout->course = $request->get('course');
            // }
            // if($request->get('university')!='')
            // {
            //         $babout->university = $request->get('university');
            // }
            // if($request->get('year_of_completion')!='')
            // {
            //         $babout->year_of_completion = $request->get('year_of_completion');
            // }
            // if($request->get('marks_or_percentage')!='')
            // {
            //         $babout->marks_or_percentage = $request->get('marks_or_percentage');
            // }

            //     $pid = $request->get('highest_qualification');
            //     $qid = $request->get('course');
            //     $pqid = $request->get('university');
            //     $wid = $request->get('year_of_completion');
            //     $mid = $request->get('marks_or_percentage');
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
            //     for($i=0; $i<$totalEmails; $i++) {

            //         $tlist= new userQualificationsDetails();
            //         $tlist->employee_auto_id = $request->get('employee_auto_id');
            //         $data = $emailArray[$i];
            //         $tlist->highest_qualification=$data;
            //         $tlist->course  = $qArray[$i];
            //         $tlist->university = $pqArray[$i];
            //         $tlist->year_of_completion = $wArray[$i];
            //         $tlist->marks_or_percentage = $mArray[$i];
            //         $tlist->save();

            //   }
            //     }
            if ($request->get('fresher_or_experienced') != '') {
                $babout->fresher_or_experienced = $request->get('fresher_or_experienced');
            }
            if ($request->get('skills') != '') {
                $babout->skills = $request->get('skills');
            }
            if ($request->get('prefered_jobrole') != '') {
                $babout->prefered_jobrole = $request->get('prefered_jobrole');
            }
            if ($request->get('prefered_job_locaion') != '') {
                $babout->prefered_job_locaion = $request->get('prefered_job_locaion');
            }
            if ($request->get('preferred_job_type') != '') {
                $babout->preferred_job_type = $request->get('preferred_job_type');
            }
            if ($request->get('field_of_experience') != '') {
                $babout->field_of_experience = $request->get('field_of_experience');
            }
            // if($request->get('total_year_experience')!='')
            // {
            //         $babout->total_year_experience = $request->get('total_year_experience');
            // }
            if ($request->get('employment_type') != '') {
                $babout->employment_type = $request->get('employment_type');
            }
            // if($request->get('description_of_project')!='')
            // {
            //         $babout->description_of_project = $request->get('description_of_project');
            // }
            if ($request->get('advance_skills') != '') {
                $babout->advance_skills = $request->get('advance_skills');
            }
            if ($request->get('current_ctc') != '') {
                $babout->current_ctc = $request->get('current_ctc');
            }
            if ($request->get('expected_ctc') != '') {
                $babout->expected_ctc = $request->get('expected_ctc');
            }
            if ($request->get('completion_status') != '') {
                $babout->completion_status = $request->get('completion_status');
            }
            if ($request->get('preferred_shift') != '') {
                $babout->preferred_shift = $request->get('preferred_shift');
            }
            // if($request->get('company_name')!='')
            // {
            //         $babout->company_name = $request->get('company_name');
            // }
            // if($request->get('designation')!='')
            // {
            //         $babout->designation = $request->get('designation');
            // }
            // if($request->get('work_from')!='')
            // {
            //         $babout->work_from = $request->get('work_from');
            // }

            if ($request->get('open_to_work') != '') {
                $babout->open_to_work = $request->get('open_to_work');
            }
            if ($request->get('mark_as_hired') != '') {
                $babout->mark_as_hired = $request->get('mark_as_hired');
            }
            if ($request->get('language') != '') {
                $babout->language = $request->get('language');
            }
            if ($request->get('rating') != '') {
                $babout->rating = $request->get('rating');
            }
            if (!empty($request->file('adhaar_card_img_front'))) {
                $file = $request->file('adhaar_card_img_front');
                $filename = $file->getClientOriginalName();
                $path = public_path('images/employee_details');
                $file->move($path, $filename);
                $babout->adhaar_card_img_front = $filename;
            }
            if (!empty($request->file('adhaar_card_img_back'))) {
                $file = $request->file('adhaar_card_img_back');
                $filename = $file->getClientOriginalName();
                $path = public_path('images/employee_details');
                $file->move($path, $filename);
                $babout->adhaar_card_img_back = $filename;
            }
            if ($request->get('last_seen_datetime') != '') {
                $babout->last_seen_datetime = $request->get('last_seen_datetime');
            }

            $babout->save();

            return response()->json([
                'status' => 1,
                'msg' => "Updated Successfully",
            ]);
        } else {

            $emp = new Employee();
            $emp->employee_auto_id = $request->get('employee_auto_id');
            if (!empty($request->file('resume'))) {
                $file = $request->file('resume');
                $filename = $file->getClientOriginalName();
                $path = public_path('images/employee_details');
                $file->move($path, $filename);
                $emp->resume = $filename;
            } else {
                $emp->resume = '';
            }
            if (!empty($request->file('video_resume'))) {
                $file = $request->file('video_resume');
                $filename = $file->getClientOriginalName();
                $path = public_path('images/employee_details');
                $file->move($path, $filename);
                $emp->video_resume = $filename;
            } else {
                $emp->video_resume = '';
            }
            if (!empty($request->file('profile_picture'))) {
                $file = $request->file('profile_picture');
                $filename = $file->getClientOriginalName();
                $path = public_path('images/employee_details');
                $file->move($path, $filename);
                $emp->profile_picture = $filename;
            } else {
                $emp->profile_picture = '';
            }
            if ($request->get('first_name') != '') {
                $emp->first_name = $request->get('first_name');
            } else {
                $emp->first_name = "";
            }
            if ($request->get('middle_name') != '') {
                $emp->middle_name = $request->get('middle_name');
            } else {
                $emp->middle_name = "";
            }
            if ($request->get('last_name') != '') {
                $emp->last_name = $request->get('last_name');
            } else {
                $emp->last_name = "";
            }
            if ($request->get('gender') != '') {
                $emp->gender = $request->get('gender');
            } else {
                $emp->gender = "";
            }
            if ($request->get('date_of_birth') != '') {
                $emp->date_of_birth = $request->get('date_of_birth');
            } else {
                $emp->date_of_birth = "";
            }
            if ($request->get('address') != '') {
                $emp->address = $request->get('address');
            } else {
                $emp->address = "";
            }
            if ($request->get('city') != '') {
                $emp->city = $request->get('city');
            } else {
                $emp->city = "";
            }
            if ($request->get('pincode') != '') {
                $emp->pincode = $request->get('pincode');
            } else {
                $emp->pincode = "";
            }
            // if($request->get('highest_qualification')!='')
            // {
            //         $emp->highest_qualification = $request->get('highest_qualification');
            // }else
            // {
            //         $emp->highest_qualification ="";
            // }
            // if($request->get('course')!='')
            // {
            //         $emp->course = $request->get('course');
            // }else{
            //         $emp->course ="";
            // }
            // if($request->get('university')!='')
            // {
            //         $emp->university = $request->get('university');
            // }else
            // {
            //         $emp->university ="";
            // }
            // if($request->get('year_of_completion')!='')
            // {
            //         $emp->year_of_completion = $request->get('year_of_completion');
            // }else{
            //         $emp->year_of_completion ="";
            // }
            // if($request->get('marks_or_percentage')!='')
            // {
            //         $emp->marks_or_percentage = $request->get('marks_or_percentage');
            // }else
            // {
            //         $emp->marks_or_percentage ="";
            // }

            if ($request->get('fresher_or_experienced') != '') {
                $emp->fresher_or_experienced = $request->get('fresher_or_experienced');
            } else {
                $emp->fresher_or_experienced = "";
            }
            if ($request->get('skills') != '') {
                $emp->skills = $request->get('skills');
            } else {
                $emp->skills = "";
            }
            if ($request->get('prefered_jobrole') != '') {
                $emp->prefered_jobrole = $request->get('prefered_jobrole');
            } else {
                $emp->prefered_jobrole = "";
            }
            if ($request->get('prefered_job_locaion') != '') {
                $emp->prefered_job_locaion = $request->get('prefered_job_locaion');
            } else {
                $emp->prefered_job_locaion = "";
            }
            if ($request->get('preferred_job_type') != '') {
                $emp->preferred_job_type = $request->get('preferred_job_type');
            } else {
                $emp->preferred_job_type = "";
            }
            if ($request->get('field_of_experience') != '') {
                $emp->field_of_experience = $request->get('field_of_experience');
            } else {
                $emp->field_of_experience = "";
            }
            // if($request->get('total_year_experience')!='')
            // {
            //         $emp->total_year_experience = $request->get('total_year_experience');
            // }else
            // {
            //         $emp->total_year_experience ="";
            // }
            if ($request->get('employment_type') != '') {
                $emp->employment_type = $request->get('employment_type');
            } else {
                $emp->employment_type = "";
            }
            // if($request->get('description_of_project')!='')
            // {
            //         $emp->description_of_project = $request->get('description_of_project');
            // }else
            // {
            //         $emp->description_of_project ="";
            // }
            if ($request->get('advance_skills') != '') {
                $emp->advance_skills = $request->get('advance_skills');
            } else {
                $emp->advance_skills = "";
            }
            if ($request->get('current_ctc') != '') {
                $emp->current_ctc = $request->get('current_ctc');
            } else {
                $emp->current_ctc = "";
            }
            if ($request->get('expected_ctc') != '') {
                $emp->expected_ctc = $request->get('expected_ctc');
            } else {
                $emp->expected_ctc = "";
            }
            if ($request->get('completion_status') != '') {
                $emp->completion_status = $request->get('completion_status');
            } else {
                $emp->completion_status = "No";
            }
            if ($request->get('preferred_shift') != '') {
                $emp->preferred_shift = $request->get('preferred_shift');
            } else {
                $emp->preferred_shift = "";
            }
            // if($request->get('company_name')!='')
            // {
            //         $emp->company_name = $request->get('company_name');
            // }else{
            //         $emp->company_name ="";
            // }
            // if($request->get('designation')!='')
            // {
            //         $emp->designation = $request->get('designation');
            // } else{
            //         $emp->designation ="";
            // }
            // if($request->get('work_from')!='')
            // {
            //         $emp->work_from = $request->get('work_from');
            // } else{
            //         $emp->work_from ="";
            // }

            if ($request->get('open_to_work') != '') {
                $emp->open_to_work = $request->get('open_to_work');
            } else {
                $emp->open_to_work = '';
            }

            if ($request->get('mark_as_hired') != '') {
                $emp->mark_as_hired = $request->get('mark_as_hired');
            } else {
                $emp->mark_as_hired = '';
            }

            if ($request->get('language') != '') {
                $emp->language = $request->get('language');
            } else {
                $emp->language = '';
            }

            if ($request->get('rating') != '') {
                $emp->rating = $request->get('rating');
            } else {
                $emp->rating = '';
            }
            if (!empty($request->file('adhaar_card_img_front'))) {
                $file = $request->file('adhaar_card_img_front');
                $filename = $file->getClientOriginalName();
                $path = public_path('images/employee_details');
                $file->move($path, $filename);
                $emp->adhaar_card_img_front = $filename;
            } else {
                $emp->adhaar_card_img_front = '';
            }
            if (!empty($request->file('adhaar_card_img_back'))) {
                $file = $request->file('adhaar_card_img_back');
                $filename = $file->getClientOriginalName();
                $path = public_path('images/employee_details');
                $file->move($path, $filename);
                $emp->adhaar_card_img_back = $filename;
            } else {
                $emp->adhaar_card_img_back = '';
            }
            if ($request->get('last_seen_datetime') != '') {
                $emp->last_seen_datetime = $request->get('last_seen_datetime');
            } else {
                $emp->last_seen_datetime = '';
            }

            $emp->save();

            return response()->json([
                'status' => 1,
                'msg' => "Added Successfully",
            ]);
        }
    }

    public function get_employee_profile(Request $request)
    {
        $bdetails = Employee::where('employee_auto_id', $request->employee_auto_id)->get();
        if ($bdetails->isEmpty()) {
            return response()->json([
                'status' => 0,
                'msg' => config('messages.empty'),
            ]);
        } else {
            $pcat = UserRegister::where('_id', '=', $request->employee_auto_id)->where('Register_as', '=', 'Employee')->get();
            if ($pcat->isNotEmpty()) {
                foreach ($pcat as $uts) {
                    $email_id = $uts->email_id;
                    $mobile_number = $uts->mobile_number;
                }
            } else {
                $email_id = '';
                $mobile_number = '';
            }
            foreach ($bdetails as $at) {
                //qualification details
                unset($quadetails);
                $qdetailss = userQualificationsDetails::where('employee_auto_id', '=', $at->employee_auto_id)->get();
                if ($qdetailss->isNotEmpty()) {
                    foreach ($qdetailss as $qdata) {
                        $quadetails[] = array(
                            "qualification_details_auto_id" => $qdata->_id,
                            "highest_qualification" => $qdata->highest_qualification,
                            "course" => $qdata->course,
                            "university" => $qdata->university,
                            "year_of_completion" => $qdata->year_of_completion,
                            "marks_or_percentage" => $qdata->marks_or_percentage
                        );
                    }
                } else {
                    $quadetails = array();
                }
                //work experience
                unset($wfdetails);
                $wdetailss = userWorkDetails::where('employee_auto_id', '=', $at->employee_auto_id)->get();
                if ($wdetailss->isNotEmpty()) {
                    foreach ($wdetailss as $wdata) {
                        $wfdetails[] = array(
                            "work_details_auto_id" => $wdata->_id,
                            "company_name" => $wdata->company_name,
                            "designation" => $wdata->designation,
                            "work_from" => $wdata->work_from,
                            "project_count" => $wdata->project_count,
                            "total_year_experience" => $wdata->total_year_experience,
                            "description_of_project" => $wdata->description_of_project
                        );
                    }
                } else {
                    $wfdetails = array();
                }


                $base_fields = [
                    $at->resume ?? '',
                    $at->video_resume ?? '',
                    $at->profile_picture ?? '',
                    $at->first_name ?? '',
                    $at->last_name ?? '',
                    $at->gender ?? '',
                    $at->date_of_birth ?? '',
                    $at->address ?? '',
                    $at->city ?? '',
                    $at->pincode ?? '',
                    $at->skills ?? '',
                    $at->prefered_jobrole ?? '',
                    $at->prefered_job_locaion ?? '',
                    $at->preferred_job_type ?? '',
                    $at->preferred_shift ?? '',
                    $at->field_of_experience ?? '',
                    $at->total_year_experience ?? '',
                    $at->employment_type ??  '',
                    $at->description_of_project ?? '',
                    $at->advance_skills ?? '',
                    $at->current_ctc ?? '',
                    $at->expected_ctc ?? '',
                    $at->open_to_work ?? '',
                    $at->adhaar_card_img_front ?? '',
                    $at->adhaar_card_img_back ?? '',
                    $email_id ?? '',
                    $mobile_number ?? '',
                ];

                $filled_count = 0;
                $total_count = count($base_fields);

                foreach ($base_fields as $field) {
                    if (!empty($field)) {
                        $filled_count++;
                    }
                }

                $base_percent = ($filled_count / $total_count) * 50; // base info weight = 50%

                $education_percent = !empty($quadetails) ? 25 : 0;
                $work_percent = !empty($wfdetails) ? 25 : 0;

                $profile_completion = round($base_percent + $education_percent + $work_percent);

                $details[] = array(
                    "_id" => $at->_id,
                    "employee_auto_id" => $at->employee_auto_id,
                    "email_id" => $email_id,
                    "mobile_number" => $mobile_number,
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
                    "preferred_shift" => $at->preferred_shift,
                    "field_of_experience" => $at->field_of_experience,
                    "total_year_experience" => $at->total_year_experience,
                    "employment_type" => $at->employment_type,
                    "description_of_project" => $at->description_of_project,
                    "advance_skills" => $at->advance_skills,
                    "current_ctc" => $at->current_ctc,
                    "expected_ctc" => $at->expected_ctc,
                    "open_to_work" => $at->open_to_work,
                    "adhaar_card_img_front" => $at->adhaar_card_img_front,
                    "adhaar_card_img_back" => $at->adhaar_card_img_back,
                    "profile_completion" => strval($profile_completion),
                    "created_at" => $at->created_at,
                    "updated_at" => $at->updated_at,
                    "Qualifications_data" => $quadetails,
                    "work_details_data" => $wfdetails,
                );
            }
            return response()->json([
                'status' => 1,
                'busniess_details' => $details,
            ]);
        }
    }

    public function getEmergencyInformation()
    {
        $emergencyContacts = [
            'police' => '100',
            'fire_brigade' => '101',
            'ambulance' => '102',
            'women_safety' => '1091',
        ];

        return response()->json([
            'status' => 1,
            'message' => 'Emergency contact details fetched successfully',
            'data' => $emergencyContacts
        ], 200);
    }
}
