<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Product;
use App\MainCategory;
use App\SubCategory;
use App\ProductWeightPricing;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Input;
use Session;
use DB;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;
class ProductPricingController extends Controller
{
  use Features;
  use VendorPaidOrder;

 public function show_product_pricing($id){
    
    $metadata = ProductWeightPricing::where('product_auto_id','=',$id)->get();
    
    $features = $this->getfeatures();
        if(empty($features)){
              return redirect('MyDashboard')->with( 'error', "Something went wrong");
        }
        else{
          return view('templates.myadmin.ProductPricing',['products'=>$metadata, 'allfeatures' => $features, 'product_auto_id'=>$id]);
        }
   
    }
    
    public function newproduct_price($id)
    {
    
    $product = Product::where('_id',$id)->get();
    
     foreach($product as $data){
      // print_r( $product_name_english = $data->product_name_english) ;
      $product_name_english = $data->product_name_english;
        }
     
      $unit = Unit::get();
      
          $features = $this->getfeatures();
            if(empty($features)){
              return redirect('MyDashboard')->with( 'error', "Something went wrong");
            }
            else{
              return view('templates.myadmin.NewProductPricing',['products'=>$product, 'units' => $unit, 'allfeatures' => $features,'product_auto_id'=>$id,'pname'=>$product_name_english]);
            }
    }


    public function storeproduct_price(Request $request)
    {
         $features = $this->getfeatures();
        if(empty($features)){
              return redirect('MyDashboard')->with( 'error', "Something went wrong");
        }
        
          $this->validate(
            $request, 
            [   
              'product_auto_id' =>'required',
              'pname'        => 'required',
              'qty'        => 'required',
               'pweight'        => 'required',
              // 'gross_weight'        => 'required',
              // 'net_weight'        => 'required',
              'price'        => 'required',
              'product_discount'        => 'required',
            ],
            [   
              'product_auto_id.required'     =>'Enter product id',
              'pname.required'   => 'Enter product name',
              'qty.required'     => 'Enter product quantity.',
              'pweight.required' => 'Select product weight',
              // 'gross_weight.required' => 'Enter net weight',
              // 'net_weight.required' => 'Enter product weight',
               'price.required'   => 'Enter product price.',
              'product_discount.required'    => 'Enter product offer percentage', 
            ]
          );
          if( $request->input('pweight') != '')
        {
           $subcategory = Unit::where('_id','=', $request->input('pweight'))->get();
           foreach($subcategory as $sub)
           {
                $unit_auto_id = $sub->_id;
                $unit_name = $sub->unit;
            
           }
        }else{
            $unit_auto_id = '';
            $unit_name = '';
          
        }
        
          $offer_perinprice =  ($request->input('price')*($request->input('product_discount')/100));
       $final_price =$request->input('price') - $offer_perinprice;
        $ProductWeightPricing = new ProductWeightPricing();
        $product_auto_id = $request->input('product_auto_id');
        $ProductWeightPricing->product_auto_id = $product_auto_id;
        $ProductWeightPricing->product_name = $request->input('pname');
        $ProductWeightPricing->qty  = $request->input('qty');
        
       
        $ProductWeightPricing->unit_auto_id = $unit_auto_id;
        $ProductWeightPricing->product_weight = $unit_name;
       
        
        if(in_array('Gross Weight',$features))
        {
        $ProductWeightPricing->gross_weight  = $request->input('gross_weight');
        }else{
              if($request->get('gross_weight') == ""){
                $ProductWeightPricing->gross_weight = "";
            }else{
                 $ProductWeightPricing->gross_weight = $request->get('gross_weight');
            }
        }
        
        if(in_array('Net Weight',$features))
        {
        $ProductWeightPricing->net_weight  = $request->input('net_weight');
        }else{
           if($request->get('net_weight') == ""){
                $ProductWeightPricing->net_weight = "";
            }else{
                 $ProductWeightPricing->net_weight = $request->get('net_weight');
            }
        } 
        //  if(!in_array('Multiprice',$features))
        // {
        $ProductWeightPricing->product_price  = $request->input('price');
      //   }else{
        
      //   $ProductWeightPricing->product_price = "";
      // }
        $ProductWeightPricing->offer_per  = $request->input('product_discount');
        $ProductWeightPricing->offer_perinprice  = $offer_perinprice;
        $ProductWeightPricing->final_price  =$final_price;
        $ProductWeightPricing->save();

    return redirect("ProductPricing/{$product_auto_id}")->with('success', 'Added Successfully');
    
    }
    
    public function editproduct_price($id){
            // $vid = Session::get('AccessToken');
           $get_pricing_data = ProductWeightPricing::Where('_id',$id)->get();
              foreach($get_pricing_data as $data){
                        $product_auto_id = $data->product_auto_id;
                    }
              $unit = Unit::get();
            $features = $this->getfeatures();
            if(empty($features)){
              return redirect('MyDashboard')->with( 'error', "Something went wrong");
            }
            else{
                
                 return view('templates.myadmin.EditProductPricing',['ProductPricing'=>$get_pricing_data ,'units'=> $unit,'allfeatures' => $features,'product_auto_id'=>$product_auto_id]);
                
                }
    }
    
    
    public function updateproduct_price(Request $request){
         $features = $this->getfeatures();
        if(empty($features)){
              return redirect('MyDashboard')->with( 'error', "Something went wrong");
        }
        
         $this->validate(
            $request, 
            [   
              'product_auto_id' =>'required',
              'pname'        => 'required',
              'qty'        => 'required',
             'pweight'        => 'required',
              'price'        => 'required',
               // 'gross_weight'        => 'required',
               // 'net_weight'        => 'required',
              'product_discount'        => 'required',
            ],
            [   
              'product_auto_id.required'     =>'Enter product id',
              'pname.required'   => 'Enter product name',
              'qty.required'     => 'Enter product quantity.',
              'pweight.required' => 'Select product weight',
               // 'gross_weight.required' => 'Enter net weight',
               // 'net_weight.required' => 'Enter product weight',
              'price.required'   => 'Enter product price.',
              'product_discount.required'    => 'Enter product offer percentage', 
            ]
          );
        
       if( $request->input('pweight') != '')
        {
           $subcategory = Unit::where('_id','=', $request->input('pweight'))->get();
           foreach($subcategory as $sub)
           {
                $unit_auto_id = $sub->_id;
                $unit_name = $sub->unit;
            
           }
        }else{
            $unit_auto_id = '';
            $unit_name = '';
          
        }
       $offer_perinprice =  ($request->input('price')*($request->input('product_discount')/100));
       $final_price =$request->input('price') - $offer_perinprice;
   
        $ProductWeightPricing = ProductWeightPricing::find($request->get('pid'));
        $product_auto_id = $request->input('product_auto_id');
        $ProductWeightPricing->qty  = $request->input('qty');
       
        $ProductWeightPricing->unit_auto_id = $unit_auto_id;
        $ProductWeightPricing->product_weight = $unit_name;       
            
        if(in_array('Gross Weight',$features))
        {
        $ProductWeightPricing->gross_weight  = $request->input('gross_weight');
        }else{
             if($request->input('gross_weight') == ""){
                $ProductWeightPricing->gross_weight = "";
            }else{
                 $ProductWeightPricing->gross_weight = $request->input('gross_weight');
            }
        }
        
        if(in_array('Net Weight',$features))
        {
        $ProductWeightPricing->net_weight  = $request->input('net_weight');
        }else{
            if($request->input('net_weight') == ""){
                $ProductWeightPricing->net_weight = "";
            }else{
                 $ProductWeightPricing->net_weight = $request->input('net_weight');
            }
        }

        //  if(!in_array('Multiprice',$features))
        // {
        $ProductWeightPricing->product_price  = $request->input('price');
      //   }else{
        
      //   $ProductWeightPricing->product_price = "";
      // }
        $ProductWeightPricing->offer_per  = $request->input('product_discount');
        $ProductWeightPricing->offer_perinprice  = $offer_perinprice;
        $ProductWeightPricing->final_price  =$final_price;
        $ProductWeightPricing->save();

    return redirect("ProductPricing/{$product_auto_id}")->with('success', 'Updated Successfully');
       
    }
    
    public function destroy_productpricing($id,$pid){
        
        
        $product = ProductWeightPricing::find($id);
        $product->delete();
        
        
        return redirect("ProductPricing/{$pid}")->with('success', 'Deleted Successfully');   
    }
   
}