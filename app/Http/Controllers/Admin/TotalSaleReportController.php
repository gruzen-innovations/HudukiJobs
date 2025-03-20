<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TotalSalesDaily;
use App\TotalSalesMonthly;
use App\TotalSalesYearly;
use App\WholeSaler;
use App\Uorders;

class TotalSaleReportController extends Controller
{
    public function total_sales_daily(){
        
         $day45 = date('Y-m-d', strtotime('today - 45 days'));
        
        
        $reports = TotalSalesDaily::get();
        if($reports->isEmpty()){
            $reports = array();
        }
        $metadata = Uorders::where('status','=','Delivered')->where('order_date','>',$day45)->ORDERBY('_id', 'DESC')->get();					
        return view('templates.myadmin.total_sales_report_daily')->with(['allreports'=>$metadata]);
    }

    public function total_sales_monthly(){
        $reports = TotalSalesMonthly::get();
        if($reports->isEmpty()){
            $reports = array();
        }
        $metadata = Uorders::where('status','=','Delivered')->ORDERBY('_id', 'DESC')->get();			
        return view('templates.myadmin.total_sales_report_monthly')->with(['allreports'=>$metadata]);
    }

    public function total_sales_yearly(){
        $reports = TotalSalesYearly::get();
        if($reports->isEmpty()){
            $reports = array();
        }			
        $metadata = Uorders::where('status','=','Delivered')->ORDERBY('_id', 'DESC')->get();					
        return view('templates.myadmin.total_sales_report_yearly')->with(['allreports'=>$metadata]);
    }
}