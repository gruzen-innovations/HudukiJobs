<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WholeSalerController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ChargesController;
use App\Http\Controllers\Admin\ExpressDeliveryController;
use App\Http\Controllers\Admin\NotificationSettingsController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Admin\PrivacyController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PincodeController;
use App\Http\Controllers\Admin\AppBaseDataController;
use App\Http\Controllers\Admin\OrderHistoryController;
use App\Http\Controllers\Admin\SalesReportController;
use App\Http\Controllers\Admin\ProductSpecificationController;
use App\Http\Controllers\Admin\PlanHistoryController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\QWPController;
use App\Http\Controllers\Admin\HMBIController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Start Main Dashboard All Routes
// home
Route::get('/MyDashboard', function () {
    return view('templates.myadmin.login');
});
Route::get('privacy', function () {
    return view('templates.frontend.privacy');
});
Route::post('adminlogin', [AdminController::class, 'store']);
Route::get('logout', [AdminController::class, 'logout']);
Route::get('/home', [AdminController::class, 'home']);


// profile
Route::get('/profile', [AdminController::class, 'index']);
Route::post('/update-profile', [AdminController::class, 'update_profile']);
// Route::get('/register', [AdminController::class, 'register']);

// Account
Route::get('/account', [AdminController::class, 'add_account']);
Route::post('update-password', [AdminController::class, 'update']);

// employer
Route::get('/wholesalers', [WholeSalerController::class, 'index']);
Route::get('/edit-user/{id}', [WholeSalerController::class, 'edit']);
Route::get('/view_posted_jobs_list/{id}', [WholeSalerController::class, 'view_posted_jobs_list']);
Route::post('update-wholesaler-status', [WholeSalerController::class, 'update']);

// employee
Route::get('/employee', [WholeSalerController::class, 'index_employee']);
Route::get('/edit-employee/{id}', [WholeSalerController::class, 'edit_employee']);
Route::post('update-employee-status', [WholeSalerController::class, 'update_employee']);
//Product Category
Route::get('/main-category', [CategoryController::class, 'jewellery_index']);
Route::get('/add-productcategory', [CategoryController::class, 'add']);
Route::post('add-main-category', [CategoryController::class, 'store']);
Route::get('/edit-main-category/{id}', [CategoryController::class, 'edit']);
Route::post('/update-main-category', [CategoryController::class, 'updates']);
Route::get('/stock-list', [CategoryController::class, 'stock_list_index']);
Route::get('/edit-stock-list/{id}', [CategoryController::class, 'edit_stock']);
Route::post('/update-stock-list', [CategoryController::class, 'updates_stock']);

//Slider
Route::get('slider', [SliderController::class, 'index']);
Route::get('add-slider', [SliderController::class, 'show']);
Route::post('store-slider', [SliderController::class, 'store']);
Route::get('edit-slider/{id}', [SliderController::class, 'edit']);
Route::post('update-slider', [SliderController::class, 'update']);
Route::get('delete-slider/{id}', [SliderController::class, 'delete']);

// Charges
Route::get('charges', [ChargesController::class, 'index']);
Route::post('update-charges', [ChargesController::class, 'update']);
// Express Delivery
Route::get('expressDelivery', [ExpressDeliveryController::class, 'index']);
Route::post('update-expressDelivery', [ExpressDeliveryController::class, 'update']);
// Notification Settings
Route::get('notification-setting', [NotificationSettingsController::class, 'index']);
Route::post('update-notification-setting', [NotificationSettingsController::class, 'update']);
// About Us
Route::get('about', [AboutController::class, 'index']);
Route::post('update-about', [AboutController::class, 'update']);
// Terms and Conditions
Route::get('term-condition', [TermController::class, 'index']);
Route::post('update-term-condition', [TermController::class, 'update']);
// Privacy Policy
Route::get('privacy-policy', [PrivacyController::class, 'index']);
Route::post('update-privacy-policy', [PrivacyController::class, 'update']);
// Settings
Route::get('setting', [SettingController::class, 'index']);
Route::post('update-setting', [SettingController::class, 'update']);
//Currency
Route::get('currency', [CurrencyController::class, 'currency']);
Route::post('updateCurrency', [CurrencyController::class, 'updateCurrency']);
// Faq
Route::get('faq', [FaqController::class, 'index']);
Route::post('update-faq', [FaqController::class, 'update']);
// Pincode
Route::get('pincode', [PincodeController::class, 'index']);
Route::get('add-pincode', [PincodeController::class, 'show_add']);
Route::post('add-pin-code', [PincodeController::class, 'store']);
Route::get('edit-pincode/{id}', [PincodeController::class, 'edit']);
Route::post('update-pincode', [PincodeController::class, 'update']);
Route::get('delete-pincode/{id}', [PincodeController::class, 'delete']);
// ecommerce plans
Route::get('ecomm-plans', [AppBaseDataController::class, 'index_eplans']);
Route::get('/add-ecomm-plans', [AppBaseDataController::class, 'add_eplans']);
Route::post('store-ecomm-plans', [AppBaseDataController::class, 'store_eplans']);
Route::get('edit-ecomm-plans/{id}', [AppBaseDataController::class, 'edit_eplans']);
Route::post('update-ecomm-plans', [AppBaseDataController::class, 'update_eplans']);
Route::get('delete-ecomm-plans/{id}', [AppBaseDataController::class, 'delete_eplans']);
//purchased history
Route::get('purchased-history', [OrderHistoryController::class, 'index']);

// Reports
Route::get('monthly-sales-report', [SalesReportController::class, 'show_monthly_sales_report']);
Route::get('yearly-sales-report', [SalesReportController::class, 'show_yearly_sales_report']);

//
Route::get('add_product_main_specification/{id}', [ProductSpecificationController::class, 'add_product_main_specification']);
Route::post('/add_main_specification', [ProductSpecificationController::class, 'add_main_specification']);

// plan history
Route::get('plan-history', [PlanHistoryController::class, 'index']);
Route::get('view_plan/{id}', [PlanHistoryController::class, 'show_details']);
Route::get('view_feature/{id}', [PlanHistoryController::class, 'show_features']);

// Notifications
Route::get('notifications', [NotificationsController::class, 'index']);
Route::get('add_notification', [NotificationsController::class, 'show']);
Route::post('addnotify', [NotificationsController::class, 'store']);
Route::get('delete-notise/{id}', [NotificationsController::class, 'delete']);
Route::get('edit-notification/{id}', [NotificationsController::class, 'show_edit']);
Route::post('update-noties', [NotificationsController::class, 'update']);
Route::get('view-notification/{id}', [NotificationsController::class, 'view_notification']);
// Enquiry
Route::get('/enquiry', [EnquiryController::class, 'index']);
Route::get('deleteEnquiry/{id}', [EnquiryController::class, 'delete']);


//Professions
Route::get('profession', [QWPController::class, 'index']);
Route::get('/add-profession', [QWPController::class, 'add']);
Route::post('store-profession', [QWPController::class, 'store']);
Route::get('edit-profession/{id}', [QWPController::class, 'edit']);
Route::post('update-profession', [QWPController::class, 'update']);
Route::get('delete-profession/{id}', [QWPController::class, 'delete']);
//working
Route::get('working', [QWPController::class, 'index_working']);
Route::get('/add-working', [QWPController::class, 'add_working']);
Route::post('store-working', [QWPController::class, 'store_working']);
Route::get('edit-working/{id}', [QWPController::class, 'edit_working']);
Route::post('update-working', [QWPController::class, 'update_working']);
Route::get('delete-working/{id}', [QWPController::class, 'delete_working']);
//Qualification
Route::get('qualification', [QWPController::class, 'index_qualification']);
Route::get('/add-qualification', [QWPController::class, 'add_qualification']);
Route::post('store-qualification', [QWPController::class, 'store_qualification']);
Route::get('edit-qualification/{id}', [QWPController::class, 'edit_qualification']);
Route::post('update-qualification', [QWPController::class, 'update_qualification']);
Route::get('delete-qualification/{id}', [QWPController::class, 'delete_qualification']);
//height
Route::get('height', [HMBIController::class, 'index_height']);
Route::get('/add-height', [HMBIController::class, 'add_height']);
Route::post('store-height', [HMBIController::class, 'store_height']);
Route::get('edit-height/{id}', [HMBIController::class, 'edit_height']);
Route::post('update-height', [HMBIController::class, 'update_height']);
Route::get('delete-height/{id}', [HMBIController::class, 'delete_height']);
//advance skills
Route::get('advance-skills', [HMBIController::class, 'index_advance_skills']);
Route::get('/add-advance-skills', [HMBIController::class, 'add_advance_skills']);
Route::post('store-advance-skills', [HMBIController::class, 'store_advance_skills']);
Route::get('edit-advance-skills/{id}', [HMBIController::class, 'edit_advance_skills']);
Route::post('update-advance-skills', [HMBIController::class, 'update_advance_skills']);
Route::get('delete-advance-skills/{id}', [HMBIController::class, 'delete_advance_skills']);

Route::get('/training-videos', [SettingController::class, 'training_videos']);
Route::get('/add-video', [SettingController::class, 'add_video']);
Route::post('/store-video', [SettingController::class, 'store_video']);
Route::post('delete-video/{id}', [SettingController::class, 'delete_video']);


Route::get('subjects',[SettingController::class,'getSubjects']);
Route::post('add-subject',[SettingController::class,'addSubject']);
Route::post('update-subject',[SettingController::class,'updateSubject']);
Route::get('delete-subject/{id}',[SettingController::class,'deleteSubject']);

Route::post('add-subject-pdf',[SettingController::class,'addSubjectPdf']);
Route::get('delete-subject-pdf/{id}',[SettingController::class,'deleteSubjectPdf']);

//test api resp
Route::get('test_resp', [HMBIController::class, 'test_resp']);
