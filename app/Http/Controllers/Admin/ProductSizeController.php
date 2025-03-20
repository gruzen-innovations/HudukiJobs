<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductSize;
use App\Size;
use App\Product;
use App\Uorders;
use Session;
use DB;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;

class ProductSizeController extends Controller
{
  use Features;
  use VendorPaidOrder;
  public function index($id)
  {
    
     $productsize = ProductSize::where('product_auto_id',$id)->get();
    

  $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
    // $features = array();
   return view('templates.myadmin.productsize')->with(['productsizes'=> $productsize,'pid'=>$id,'allfeatures' => $features]);
 }
}

 public function show($id)
 {
  $size = Size::get();
  $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
             // $features = array();
           return view('templates.myadmin.add_productsize')->with(['productsizes'=> $size,'pid'=> $id,'allfeatures' => $features]);
}
}

public function store(Request $request)
{
 $this->validate(
  $request, 
  [  
    'size' =>'required',
   ],
  [   
    'size.required' => 'Select product size',
  ]
);
         $sizes = Size::where('_id','=', $request->get('size'))->get();

        foreach ($sizes as $siz) {
           $size_auto_id = $siz->id;
              $size = $siz->size;
         }
  $ProductSize = new ProductSize();
  $ProductSize->product_auto_id = $request->input('id');
  $ProductSize->size= $request->input('size');
  $ProductSize->size_auto_id = $size_auto_id;
  $ProductSize->size = $size;
  $ProductSize->save();
  return redirect('productsize/'.$request->input('id'))->with('success','Added Successfully');
  }

public function delete($id)
{
  $productsizes = ProductSize::where('_id',$id)->get();
  foreach ($productsizes as $value) 
  {
    $pid = $value->product_auto_id;
  }

  $productsize = ProductSize::find($id);
  $productsize->delete();
  return redirect('productsize/'.$pid)->with('success', 'Deleted Successfully');
  }
}




