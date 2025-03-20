<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ManageWalletDeductionOnPurchase;
use Session;
use DB;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;

class ManageWalletDeductionOnPurchaseController extends Controller
{
    use Features;
    use VendorPaidOrder;
    public function index(){
      $wallet = ManageWalletDeductionOnPurchase::ORDERBY('_id','DESC')->get();
      $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
    	return view('templates.myadmin.manage_wallet_deduction')->with(['wallet_deductions'=> $wallet,'allfeatures' => $features]);
    }
    }
     public function show()
    {
       
       $wallet = ManageWalletDeductionOnPurchase::get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
          return view('templates.myadmin.add_manage_wallet_deduction')->with(['wallet_deductions' => $wallet,'allfeatures' => $features]);
    }
  }
    public function store(Request $request){
    	$this->validate(
          $request, 
          [   
           
            'order_amt_range' => 'required',
            'deduction_percent' => 'required',
            'max_usable_amt' => 'required',
         ],
           [   
           
            'order_amt_range.required' => 'Enter order amount range',
            'deduction_percent.required' => 'Enter deduction percent',
            'max_usable_amt.required' => 'Enter max usable amount',
           ]
      );
       
        $dwallet = new ManageWalletDeductionOnPurchase();
        $dwallet->order_amt_range= $request->get('order_amt_range');
        $dwallet->deduction_percent= $request->get('deduction_percent');
        $dwallet->max_usable_amt= $request->get('max_usable_amt');
        $dwallet->save();
        return redirect('manage-wallet-deduction')->with('success', 'Added Successfully');
    }

    public function edit($id)
    {
       $wallet = ManageWalletDeductionOnPurchase::where('_id','=',$id)->get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
          return view('templates.myadmin.edit_manage_wallet_deduction')->with(['wallet_deduction'=> $wallet,'allfeatures' => $features]);
        }
    }

    public function update(Request $request){
        $this->validate(
          $request, 
          [   
           
            'order_amt_range' => 'required',
            'deduction_percent' => 'required',
            'max_usable_amt' => 'required',
         ],
           [   
           
            'order_amt_range.required' => 'Enter order amount range',
            'deduction_percent.required' => 'Enter deduction percent',
            'max_usable_amt.required' => 'Enter max usable amount',
           ]
      );
        
        $wallet = ManageWalletDeductionOnPurchase::find($request->get('id'));
        $wallet->order_amt_range= $request->get('order_amt_range');
        $wallet->deduction_percent= $request->get('deduction_percent');
        $wallet->max_usable_amt= $request->get('max_usable_amt');
        $wallet->save();
        return redirect('manage-wallet-deduction')->with('success','Updated Successfully');
    }
    public function delete($id)
   {
        $wallet = ManageWalletDeductionOnPurchase::find($id);
        $wallet->delete();
       return redirect('manage-wallet-deduction')->with('success', 'Deleted Successfully');
  }


}

