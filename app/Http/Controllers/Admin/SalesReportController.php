<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Orders;
use DateTime;
use DB;
use Session;
use App\Traits\Features;
class SalesReportController extends Controller
{
  use Features;
    public function show_monthly_sales_report()
    {
    	$getmonth = Orders::raw()->distinct('order_month');
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        
 		return view('templates.myadmin.monthly_sales_report')->with(['alldata' => $data, 'allfeatures' => $features]);
    }
  }

    public function show_yearly_sales_report()
    {
    	$getyear = Orders::raw()->distinct('order_year');
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
 		return view('templates.myadmin.yearly_sales_report')->with(['alldata' => $data, 'allfeatures' => $features]);
    }
}
}
