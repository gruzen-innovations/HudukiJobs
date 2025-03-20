<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Plans;
use App\StorageSpaceCount;
use App\NotificationCount;
use App\Traits\Features;
use App\Traits\StorageSpace;
use Session;

class PlanHistoryController extends Controller
{
    use Features;
    use StorageSpace;
    public function index(Request $request){
        $orders = Plans::where('customer_id','=',Session::get('AccessToken'))->where('main_category_id','MCAT01')->orderBy('_id', 'DESC')->get();
        if($orders->isEmpty()){
            $orders = array();
        }
        $features = $this->getfeatures();
        if(empty($features)){
            return redirect('MyDashboard')->with( 'error', "Something went wrong");
        }
        else{
            return view('templates.myadmin.planhistory')->with(['allfeatures' => $features, 'allorders' => $orders]);
        }
    }

    public function show_details($id){
        $orders = Plans::where('_id','=',$id)->get();
        if($orders->isEmpty()){
            $orders = array();
        }
        else{
            foreach ($orders as $odetails) {
                $order_id = $odetails->order_id;
                $feature_name = $odetails->feature_name;
            }
            $order_features = explode('|', $feature_name);
            // calculate notification
            $notifications = NotificationCount::where('order_id','=',$order_id)->get();
            if($notifications->isNotEmpty()){
                foreach ($notifications as $notification) {
                    $total_notification_limit = $notification->notification_limit;
                    $remaining_notification_limit = $notification->used_notification;
                }
                $total_notification_percent = round(($remaining_notification_limit * 100)/$total_notification_limit);
            }
            else{
                $total_notification_limit = 0;
                $remaining_notification_limit = 0;
                $total_notification_percent = 0;
            }

            // get storage space
            $storagespace = StorageSpaceCount::where('order_id','=',$order_id)->get();
            if($storagespace->isNotEmpty()){
                foreach ($storagespace as $storages) {
                    $total_storage_space_limit = $storages->storage_space_limit;
                }
            }else{
                $total_storage_space_limit = 0;
            }
            // echo $total_storage_space_limit;
            // calculate total_storage_space_limit;storage space
            $path = "/home/grobiz/public_html/mobileAccessories";
            $path1 = "/home/grobiz/SubAdmin/mobile_accessories";

            $ar = $this->getDirectorySize($path,$total_storage_space_limit);
            $ar1 = $this->getDirectorySize($path1,$total_storage_space_limit);

            $total_size = $this->sizeFormat($ar['size'] + $ar1['size']);

            $storage_space_allocated_size = $this->sizeFormat($ar['allocated_size']);

            $storage_space_remaining_size = $this->sizeFormat($ar['allocated_size'] - $ar['size']);

            $storage_space_percent = round(($ar['size'] * 100)/$ar['allocated_size']);
    
            $features = $this->getfeatures();
            if(empty($features)){
                return redirect('MyDashboard')->with( 'error', "Something went wrong");
            }
            else{
                return view('templates.myadmin.view_plan_details')->with(['allfeatures' => $features, 'allorders' => $orders, 'total_notification_limit' => $total_notification_limit, 'remaining_notification_limit' => $remaining_notification_limit, 'total_notification_percent' => $total_notification_percent, 'storage_space_allocated_size' => $storage_space_allocated_size, 'storage_space_remaining_size' => $storage_space_remaining_size, 'storage_space_percent' => $storage_space_percent,'orderfeatures' => $order_features]);
            }
        }
    }

    public function show_features($id){
        $orders = Plans::where('_id',$id)->get();

        if($orders->isNotEmpty()){
            foreach ($orders as $data) {
                $feature_name = $data->feature_name;
            }
            $features = explode('|', $feature_name);
        }
        else{
            $features = array();
        }
        $allfeatures = $this->getfeatures();
        if(empty($allfeatures)){
            return redirect('MyDashboard')->with( 'error', "Something went wrong");
        }else{
            return view('templates.myadmin.view_features')->with(['features' => $features,'allfeatures' => $allfeatures]);
        }
    }
}