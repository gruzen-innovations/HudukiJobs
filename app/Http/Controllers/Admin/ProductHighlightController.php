<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductHighlight;
use DB;
use Session;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;

class ProductHighlightController extends Controller
{
    use Features;
    use VendorPaidOrder;
    public function index($id){
        
        $product = ProductHighlight::where('product_id','=',$id)->get();
        
        $features = $this->getfeatures();
        if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
        }
        else{
            return view('templates.myadmin.producthighlights')->with(['producthighlights' => $product,'allfeatures' => $features, 'product_auto_id'=>$id]);
        }
    }

    public function add_product_offer($id){
        $highlight = ProductHighlight::get();
        $features = $this->getfeatures();
        if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
        }
        else{
            return view('templates.myadmin.add_product_highlight')->with(['highlights' => $highlight, 'allfeatures' => $features, 'product_auto_id'=>$id]);
        }
    }

    public function addhighlight(Request $request){
        $this->validate($request,[
            'pid' => 'required',
            'highlight' => 'required',
        ]); 
        $poffer = new ProductHighlight();
        $poffer->product_id = $request->input('pid');
        $poffer->product_highlight = $request->input('highlight'); 
        $poffer->save();

        return redirect('view-product-highlights/'.$request->input('pid'))->with('success', 'Added Successfully');
    }

    public function edit($id)
    {
        $editquery = ProductHighlight::where('_id', '=', $id)->get();
        return view('templates.myadmin.edit_product_highlight',['phighlight'=>$editquery]);
    }  

    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request,[
            'highlight' => 'required',
        ]);
        
        DB::table('producthighlight')->where('_id', '=', $id)
            ->update(['product_highlight' => $request->input('highlight')]);
     
        
        return redirect('editproduct_highlight/'.$id)->with('success', 'Updated Successfully');
    }

    public function delete($id,$pid)
    {

        $poffer = ProductHighlight::find($id);
        $poffer->delete();
        
        return redirect('view-product-highlights/'.$pid)->with('success', 'Deleted Successfully');
    }
}