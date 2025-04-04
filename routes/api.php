<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingApiController;
use App\Http\Controllers\JobApiController;
use App\Http\Controllers\LegalApiController;
use App\Http\Controllers\PlansApiController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\VersionApiController;
use App\Http\Controllers\WorkQualificationsApiController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Users
Route::post('user_registration', [UserApiController::class, 'register']);
Route::post('send_registration_contact_otp', [UserApiController::class, 'send_registration_contact_otp']);
Route::post('verify_registration_contact_otp', [UserApiController::class, 'verify_registration_contact_otp']);
Route::post('send_registration_email_otp', [UserApiController::class, 'send_registration_email_otp']);
Route::post('verify_registration_email_otp', [UserApiController::class, 'verify_registration_email_otp']);
Route::post('login', [UserApiController::class, 'login']);
Route::post('send_employee_login_otp', [UserApiController::class, 'sendEmployerLoginOtp']);
Route::post('employee_login', [UserApiController::class, 'employeeLogin']);


Route::post('forgot_password', [UserApiController::class, 'forgotPass']);
Route::post('get_user_profile', [UserApiController::class, 'get_user_profile']);
Route::post('send_response', [UserApiController::class, 'send_response']);
Route::get('get_employee_notification', [UserApiController::class, 'get_employee_notification']);
Route::get('get_employer_notifications', [UserApiController::class, 'get_employer_notifications']);
Route::post('update_user_profile', [UserApiController::class, 'update_user_profile']);
Route::post('employee_profile', [UserApiController::class, 'get_employee_profile']);
Route::post('update_employee_profile', [UserApiController::class, 'update_employee_profile']);
//update product new keys
// Route::post('Update_product_new_keys', [FilterApiController::class, 'Update_product_new_keys']);
Route::get('get_Profession_List', [BookingApiController::class, 'get_Profession_List']);
Route::get('get_skill_list', [BookingApiController::class, 'get_skill_list']);
Route::get('get_Education_List', [BookingApiController::class, 'get_Education_List']);
Route::get('get_Locations_List', [BookingApiController::class, 'get_Locations_List']);
Route::get('get_advance_skills_List', [BookingApiController::class, 'get_advance_skills_List']);
//job
Route::post('post_job', [BookingApiController::class, 'post_job']);
Route::post('edit_job', [BookingApiController::class, 'edit_job']);
Route::post('update_job_status', [BookingApiController::class, 'update_job_status']);
Route::post('get_job_list_employer', [BookingApiController::class, 'get_job_list_employer']);
Route::post('get_active_joblist', [BookingApiController::class, 'get_active_joblist']);
Route::post('get_walkin_job', [BookingApiController::class, 'get_walkin_job']);
Route::post('get_job_list_employee', [BookingApiController::class, 'get_job_list_employee']);
Route::post('delete_job', [BookingApiController::class, 'delete_job']);
Route::get('get_job_search_list', [BookingApiController::class, 'get_job_search_list']);
Route::post('get_candidate_search', [BookingApiController::class, 'get_candidate_search']);
//bookmart candidate
Route::post('bookmark_candidate', [JobApiController::class, 'bookmark_candidate']);
Route::post('delete_bookmark_candidate', [JobApiController::class, 'delete_bookmark_candidate']);
Route::post('get_bookmark_candidate', [JobApiController::class, 'get_bookmark_candidate']);
//save jobs
Route::post('save_jobs', [JobApiController::class, 'save_jobs']);
Route::post('delete_save_jobs', [JobApiController::class, 'delete_save_jobs']);
Route::post('get_save_jobs', [JobApiController::class, 'get_save_jobs']);
Route::post('apply_jobs', [JobApiController::class, 'apply_jobs']);
Route::post('get_applied_jobs', [JobApiController::class, 'get_applied_jobs']);
//crm
Route::post('get_all_candidateList', [JobApiController::class, 'get_all_candidateList']);
Route::post('update_Candidate_status', [JobApiController::class, 'update_Candidate_status']);
Route::post('get_recruiter_action_jobList', [JobApiController::class, 'get_recruiter_action_jobList']);
Route::post('get_dashboard_count', [JobApiController::class, 'get_dashboard_count']);
Route::post('get_priority_candidate', [JobApiController::class, 'get_priority_candidate']);
Route::post('get_employee_list_by_status', [JobApiController::class, 'get_employee_list_by_status']);
//legel api
Route::get('Show-About',[LegalApiController::class, 'about_index']);
Route::get('Show-Terms',[LegalApiController::class, 'terms_index']);
Route::get('Show-Privacy',[LegalApiController::class, 'privacy_index']);
Route::get('Show-Faq',[LegalApiController::class, 'faq_index']);
//plan apis
Route::get('get_plans', [PlansApiController::class, 'get_plans']);
Route::post('purchase_plan', [PlansApiController::class, 'place_order']);
Route::post('orderHistory', [PlansApiController::class, 'order_history_list']);
Route::post('get_plan_status', [PlansApiController::class, 'get_plan_status']);
//work details
Route::post('add_employee_work_details', [WorkQualificationsApiController::class, 'add_employee_work_details']);
Route::post('edit_employee_work_details', [WorkQualificationsApiController::class, 'edit_employee_work_details']);
Route::post('delete_employee_work_details', [WorkQualificationsApiController::class, 'delete_employee_work_details']);
//qualification details
Route::post('add_employee_qualification_details', [WorkQualificationsApiController::class, 'add_employee_qualification_details']);
Route::post('edit_employee_qualification_details', [WorkQualificationsApiController::class, 'edit_employee_qualification_details']);
Route::post('delete_employee_qualification_details', [WorkQualificationsApiController::class, 'delete_employee_qualification_details']);
//Search History
Route::post('add_search_history', [BookingApiController::class, 'createSearchHistory']);
Route::post('get_search_history', [BookingApiController::class, 'getSearchHistory']);

//emergency information
Route::post('get_emergency_information', [UserApiController::class, 'getEmergencyInformation']);

//Company
Route::post('get_company_list', [BookingApiController::class, 'getCompanyList']);
Route::post('follow_unfollow_company', [BookingApiController::class, 'followUnfollowCompany']);
Route::post('get_follow_company_list', [BookingApiController::class, 'getFollowCompanyList']);
Route::post('get_company_follow_job_list', [BookingApiController::class, 'getCompanyFollowJobList']);


//Remainder
Route::post('add_candidate_remainder', [BookingApiController::class, 'createCandidateRemainder']);
Route::post('get_candidate_remainder', [BookingApiController::class, 'getCandidateRemainder']);
Route::post('delete_candidate_remainder', [BookingApiController::class, 'deleteCandidateRemainder']);

//Employee Report
Route::post('report_employee', [BookingApiController::class, 'createReportEmployee']);

//training Videos
Route::post('get_training_video', [BookingApiController::class, 'getTrainingVideos']);

//rate employee
Route::post('rate_employee', [BookingApiController::class, 'createRatingEmployee']);

//Subjects
Route::post('get_subject', [BookingApiController::class, 'getSubject']);
Route::post('get_subject_pdf', [BookingApiController::class, 'getSubjectpdf']);

//Admin
Route::post('get_admin_profile', [BookingApiController::class, 'getAdminProfile']);



