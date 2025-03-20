<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Charges;
use App\Country;
use App\Currency;
use DB;
use File;
use Session;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;

class CurrencyController extends Controller
{

    use Features;

 use VendorPaidOrder;
    public function currency()
    {
       
        
        $currency = Currency::get();
        $country = Country::get();
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }else{
          return view('templates.myadmin.currency')->with(['allcurrency'=>$currency, 'allcountry'=>$country, 'allfeatures'=>$features]);
       }

      }
      public function updateCurrency(Request $request){
       
      $currency = Currency::get();
      $country = Country::where('country_name','=',$request->get('currency'))->get();
      if($country->isNotEmpty()){
          foreach($country as $cnt){
              $currency_symbol = $cnt->currency;
          }
      }else{
          $currency_symbol = "";
      }
      if($currency->isNotEmpty()){
          $currency1 = Currency::find($request->get('id'));
          $currency1->currency = $currency_symbol;
          $currency1->country_name = $request->get('currency');
          $currency1->save();

          return redirect('currency')->with('success','Updated Successfully');

      }else{
         
          $currency2 = new Currency();
          $currency2->currency = $currency_symbol;
          $currency2->country_name = $request->get('currency');
          $currency2->save();

          return redirect('currency')->with('success','Added Successfully');

      }
  }
}
