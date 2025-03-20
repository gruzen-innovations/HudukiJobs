<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductOffer;
use DB;
use Session;
use App\Traits\Features;


class ProductOfferController extends Controller
{
    use Features;
    public function index($id){
        $product = ProductOffer::where('product_id','=',$id)->get();
        $features = $this->getfeatures();
        if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
        }
        else{
            return view('templates.myadmin.productoffers')->with(['productoffers' => $product,'allfeatures' => $features, 'product_auto_id'=>$id]);
        }
    }

    public function add_product_offer($id){
        $offer = ProductOffer::get();
        $features = $this->getfeatures();
        if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
        }
        else{
            return view('templates.myadmin.add_product_offer')->with(['offers' => $offer,'allfeatures' => $features, 'product_auto_id'=>$id]);
        }
    }

    public function addoffer(Request $request){
        $this->validate($request,[
            'pid' => 'required',
            'offer' => 'required',
        ]); 
        $poffer = new ProductOffer();
        $poffer->product_id = $request->input('pid');
        $poffer->product_offer = $request->input('offer'); 
        $poffer->save();

        return redirect('view-product-offers/'.$request->input('pid'))->with('success', 'Added Successfully');
    }

    public function edit($id)
    {
        $editquery = ProductOffer::where('_id', '=', $id)->get();
        return view('templates.myadmin.edit_product_offer',['pofer'=>$editquery]);
    }  

    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request,[
            'offer' => 'required',
        ]);
        
        DB::table('productoffers')->where('_id', '=', $id)
            ->update(['product_offer' => $request->input('offer')]);
     
        
        return redirect('editproduct_offer/'.$id)->with('success', 'Updated Successfully');
    }

    public function delete($id,$pid)
    {
        $poffer = ProductOffer::find($id);
        $poffer->delete();
        
        return redirect('view-product-offers/'.$pid)->with('success', 'Deleted Successfully');
    }
}