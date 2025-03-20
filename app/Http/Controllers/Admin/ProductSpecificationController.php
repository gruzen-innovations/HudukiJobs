<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductSpecification;
use App\ProductMainSpecifications;
use DB;
use Session;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;

class ProductSpecificationController extends Controller
{
    use Features;
    use VendorPaidOrder;
    public function index($id){
        
            
        $productmainspecification = ProductSpecification::where('product_auto_id', '=', $id)->get();
  
        $features = $this->getfeatures();
        if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
        }
        else{
            return view('templates.myadmin.productspecifications')->with(['allproductspecifications' => $productmainspecification,'allfeatures' => $features, 'product_auto_id'=>$id]);
        }
    }

    public function add_product_specification($id){
        $mainspecification = ProductSpecification::where('product_auto_id', '=', $id)->get();
        
        if(count($mainspecification) == 0){
            $mainspecification = array();
        }

        $features = $this->getfeatures();
        if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
        }
        else{ 
            return view('templates.myadmin.add_product_specification')->with(['allfeatures' => $features, 'product_auto_id'=>$id, 'mainspecification' => $mainspecification]);
        }
    }

    public function add_specification(Request $request){
        $this->validate($request,[
            'title' => 'required',
            'description' => 'required',
        ]); 
        $pspec = new ProductSpecification();
        $pspec->product_auto_id = $request->input('pid');
        $pspec->title = $request->input('title'); 
        $pspec->description = $request->input('description'); 
        $pspec->save();

        return redirect('view-product-specification/'.$request->input('pid'))->with('success', 'Added Successfully');
    }

    public function edit($id)
    {
        $editquery = ProductSpecification::where('_id', '=', $id)->get();
        return view('templates.myadmin.edit_product_specification',['productspec'=>$editquery]);
    }  

    public function update(Request $request)
    {
        $this->validate($request,[
            'skey' => 'required',
            'svalue' => 'required',
        ]);
        $id = $request->input('id');

        
        DB::table('productspecification')->where('_id', '=', $id)
            ->update(['product_specification_key' => $request->input('skey'), 'product_specification_value' => $request->input('svalue')]);
     
        
        return redirect('edit_product_specification/'.$id)->with('success', 'Updated Successfully');
    }

    public function delete($id,$pid)
    {

        $poffer = ProductSpecification::find($id);
        $poffer->delete();
        
        return redirect('view-product-specification/'.$pid)->with('success', 'Deleted Successfully');
    }

    public function add_product_main_specification($id){
        $specification = ProductMainSpecifications::get();
        $features = $this->getfeatures();
        if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
        }
        else{
            return view('templates.myadmin.add_product_main_specification')->with(['product_main_specifications'=> $specification, 'allfeatures' => $features, 'product_auto_id'=>$id]);
        }
    }

    public function add_main_specification(Request $request){
        $this->validate($request,[
            'pid' => 'required',
            'name' => 'required',
        ]); 
        $pspec = new ProductMainSpecifications();

        $msids = ProductMainSpecifications::get();
        if(count($msids) == 0){
            $msid = "MSID1";
        }
        else{
            $msids = ProductMainSpecifications::get();
            foreach ($msids as $demo) {
                $getid = $demo->main_specification_id;
            }
            $str = explode('MSID',$getid,2);
            $second = $str[1];
            $inc_oid = $second+1;
            $msid ="MSID".$inc_oid;
        }

        $pspec->product_auto_id = $request->input('pid');
        $pspec->main_specification_id = $msid;
        $pspec->name = $request->input('name'); 
        $pspec->save();

        return redirect('view-product-specification/'.$request->input('pid'))->with('success', 'Added Successfully');
    }
}