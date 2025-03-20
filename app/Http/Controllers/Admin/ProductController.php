<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MainCategory;
use App\SubCategory;
use App\ChildCategory;
use App\Product;
use App\ProductColor;
use App\ProductImages;
use App\ProductOffer;
use App\ProductHighlight;
use App\ProductMainSpecifications;
use App\ProductSize;
use App\ProductRatingReview;
use App\ProductWeightPricing;
use App\Brands;
use App\Unit;
use DB;
use File;
use Session;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;
use App\VendorBusinessDetails;

class ProductController extends Controller
{

    use Features;
    use VendorPaidOrder;
    public function product_index(){
       
           $product = Product::ORDERBY('_id','DESC')->get();
    
        $features = $this->getfeatures();

        if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");
        }
        else{
            return view('templates.myadmin.product')->with(['products'=>$product,'allfeatures'=> $features]);
        }
    }
    
  public function getSubCategoryBySubCategory(Request $request){
     $getSubcategory = SubCategory::where('main_category_auto_id',$request->main_category_id)->get();
    
     
      $features = $this->getfeatures();

        if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");
        }
        else{
    return view('templates.myadmin.ajaxdatasub')->with(['sub_categories' => $getSubcategory, 'allfeatures'=> $features]);
      }
  }
    

  public function getChildCategoryBySubCategory(Request $request){

     $getChildcategory = ChildCategory::where('sub_category_auto_id',$request->sub_category_id)->get();
      $features = $this->getfeatures();

        if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

        }

        else{
    return view('templates.myadmin.ajaxdatasub')->with([ 'child_categories' => $getChildcategory,'allfeatures'=> $features]);
      }
  }

    public function add_product(){
        
           $maincategory = MainCategory::get();
    
           $brands = Brands::get();
           $unit = Unit::get();
    
        $features = $this->getfeatures();

        if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");
        }
        else{
            return view('templates.myadmin.add_product')->with(['main_categories'=>$maincategory,'allfeatures' => $features, 'allbrands' => $brands,  'units' => $unit]);
        }
    }



    public function store_product(Request $request){
        
        $features = $this->getfeatures();

        if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
        }
        $this->validate($request, 

        [   
            'ename' => 'required',
             'price' => 'required',
            'edescription' => 'required',
            'nstatus' => 'required',
            'main_category_auto_id' => 'required',
            // 'sub_category_auto_id' => 'required',
            // 'child_category_auto_id' => 'required',
            // 'bname' => 'required',
             'moq' => 'required',
            // 'gross_weight' => 'required',
            // 'net_weight' => 'required',
            'stock' => 'required',
            'product_weight'=>'required',
            'pimage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_discount'        => 'required',

        ],
        [ 
            'ename.required' => 'Please enter name',
            'price.required' => 'Please enter price',
            'edescription.required' => 'Please enter description in english',
            'nstatus.required' => 'Please select new arrival status',
          'pimage.required' => 'Choose product image.',
          'pimage.image'   => 'Choose product image.',
          'pimage.mimes'   => 'product category image should be jpeg,png,jpg,gif or svg format only',
            'main_category_auto_id.required' => 'Please select main category',
            // 'sub_category_auto_id.required' => 'Please select sub category',
            // 'child_category_auto_id.required' => 'Please select child category',
            // 'bname.required' => 'Please select brand',
            'moq.required'=>'please enter maximum order quantity',
            // 'gross_weight.required' => 'please enter gross weight',
            // 'net_weight.required' => 'please enter net weight',
            'product_weight.required' => 'please enter product unit',
            'stock.required' =>'please select stock status',
            'product_discount.required'    => 'Enter product offer percentage', 

        ]);

        
       
            $maincategory = MainCategory::where('_id','=', $request->get('main_category_auto_id'))->get();
    
            foreach ($maincategory as $main) {
                $main_category_id = $main->main_category_id;
                $main_category_name = $main->main_category_name_english;
                $mcode = $main->code;
            }
       
        
        if( $request->input('sub_category_auto_id') != '')
        {
           $subcategory = SubCategory::where('_id','=', $request->input('sub_category_auto_id'))->get();
           foreach($subcategory as $sub)
           {
                $sub_category_id = $sub->sub_category_id;
                $sub_category_name = $sub->name;
                $scode = $sub->code;
           }
        }else{
            $sub_category_id = '';
                $sub_category_name = '';
                $scode = '';
        }
        
        if($request->input('child_category_auto_id') != '')
        {

         $childcategory = ChildCategory::where('_id','=', $request->input('child_category_auto_id'))->get();
           foreach($childcategory as $child)
           {
                $child_category_id = $child->child_category_id;
                $child_category_name = $child->name;
                $ccode = $child->code;
           }
        }else{
            $child_category_id = '';
                $child_category_name ='';
                $ccode ='';
        }
        
         if($request->get('bname') != '')
        {
            $brands = Brands::where('brand_id','=', $request->get('bname'))->get();
    
            foreach ($brands as $brand) {
                $brand_name = $brand->name;
            }
        }else{
            $brand_name = '';
        }

        if(!in_array('Multiprice',$features))
        {
            $units = Unit::where('_id','=', $request->get('product_weight'))->get();
    
            foreach ($units as $ut) {
                $unit_auto_id = $ut->id;
                $product_weight = $ut->unit;
            }
        }else{
             $unit_auto_id = '';
            $product_weight = '';
        }
        
            $product_id = Product::where('product_id','LIKE',$mcode.'%')->get();
            if($product_id->isNotEmpty())
            {
                foreach ($product_id as $data) 
                    {
                        $pid = $data->product_id;
                    }
    
                if($pid != ''){
                    $str = explode($mcode,$pid,3);
                    $second = $str[1];
                    $naid = $second+1;
                    $len =  strlen($naid);
                    if($len > 1){
                        $new_pid = $mcode.$naid;
                    }else{
                        $new_pid = $mcode."0".$naid;
                    }
                }   
            } else{
                $new_pid = $mcode."01";
            }

       

        
  
         $name = $request->file('pimage')->getClientOriginalName();
         $request->file('pimage')->move("images/products", $name); 
         $sdata = $name; 

        $product = new Product();
        $product->product_id = $new_pid;
        $product->product_main_category_auto_id = $request->input('main_category_auto_id');
        $product->product_main_category_id = $main_category_id;
        $product->product_main_category_name = $main_category_name;
      
        
       
        if($request->input('sub_category_auto_id') != '')
        {
            $product->product_sub_category_auto_id = $request->input('sub_category_auto_id');
            $product->product_sub_category_id = $sub_category_id;
            $product->product_sub_category_name = $sub_category_name;
        }else{
             $product->product_sub_category_auto_id = "";
              $product->product_sub_category_id = "";
            $product->product_sub_category_name = "";
        }
        
       
         if($request->input('child_category_auto_id') != '')
        {
            $product->product_child_category_auto_id = $request->input('child_category_auto_id');
            $product->product_child_category_id = $child_category_id;
            $product->product_child_category_name = $child_category_name;
        }else{
              $product->product_child_category_auto_id = "";
              $product->product_child_category_id ="";
              $product->product_child_category_name = "";
        }
        
        
        if($request->get('bname') != '')
        {
           $product->brand_id = $request->get('bname');
           $product->brand_name = $brand_name;
        }else{
           $product->brand_id ="";
           $product->brand_name = "";
        }
         if(!in_array('Multiprice',$features))
        {
           $product->unit_auto_id = $request->get('product_weight');
           $product->product_weight = $product_weight;
        }else{
           $product->unit_auto_id ="";
           $product->product_weight = "";
        }
        //   if(!in_array('Multiprice',$features))
        // {
        //      $product->product_weight = $request->input('product_weight');
        // }else{
        //     $product->product_weight = "";
        // }
        $product->product_name_english = $request->input('ename');
        
        $product->product_logo =$sdata;
       
       
        $product->descriptions_english = $request->input('edescription');
        
        if($request->input('nstatus') != '')
        {
            $product->new_arrival_status = $request->input('nstatus');
        }else{
            $product->new_arrival_status = "";
        }
        
        if(in_array('Minimum Order Quantity',$features) && (!in_array('Multiprice',$features)))
        {
             $product->moq = $request->get('moq');
        }else{
             $product->moq = "";
        }
        
        if($request->input('stock') != '')
        {
            $product->stock = $request->get('stock');
        }else{
             $product->stock = "";
        }
        
         if(in_array('Gross Weight',$features) && (!in_array('Multiprice',$features)))
        {
        
           $product->gross_weight = $request->get('gross_weight');
        }else{
           if($request->get('gross_weight') == ""){
                $product->gross_weight = "";
            }else{
                 $product->gross_weight = $request->get('gross_weight');
            }
        }
        
        
       if(!in_array('Multiprice',$features))
        {
             $product->qty = $request->get('qty');
        }else{
              $product->qty = "";
        }
        
        if(in_array('Net Weight',$features) && (!in_array('Multiprice',$features)))
        {
            $product->net_weight = $request->get('net_weight');
        }else{
            if($request->get('net_weight') == ""){
                $product->net_weight = "";
            }else{
                 $product->net_weight = $request->get('net_weight');
            }
        }
     
      
        
        if($request->input('product_status') != '')
        {
            $product->product_status = "Active";
        }else{
            $product->product_status = "Active";
        }
        
        if(!in_array('Multiprice',$features))
        {
            $product->product_price = $request->input('price');
        }else{
            $product->product_price = "";
        }
        
        if(!in_array('Multiprice',$features))
        {
             $product->offer_per = $request->input('product_discount');
        }else{
            $product->offer_per = "";
        }
        
        
        if(!in_array('Multiprice',$features))
        {
         $offer_perinprice2 =  ($request->input('price')*($request->input('product_discount')/100)); 

		 $offer_perinprice = number_format((float)$offer_perinprice2, 2, '.', '');
            
            $product->offer_perinprice  = $offer_perinprice;
        }else{
            $product->offer_perinprice  = "";
        }
        
        
        if(!in_array('Multiprice',$features))
        {
          $final_price2 =$request->input('price') - $offer_perinprice; 
		  $final_price = number_format((float)$final_price2, 2, '.', '');
            $product->final_price  =$final_price;
        }else{
             $product->final_price  ="";
        }
        
        $product->save();
        return redirect('products')->with('success', 'Successfully Added');

    }



    public function edit($id){
        
           $maincategory = MainCategory::get();
    
           $brands = Brands::get();
           $unit = Unit::get();
     
      $product = Product::where('_id','=',$id)->get();

        $features = $this->getfeatures();

       if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

       }

       else{

        return view('templates.myadmin.edit_product')->with(['products'=>$product,'main_categories'=>$maincategory,'allfeatures'=>$features,'allbrands'=> $brands, 'units'=> $unit]);

    }

}

    public function update(Request $request){

    $features = $this->getfeatures();

        if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

        }
        
        
        $this->validate($request, 

        [   
            'ename' => 'required',
             'price' => 'required',
            'edescription' => 'required',
            'nstatus' => 'required',
            'main_category_auto_id' => 'required',
            // 'sub_category_auto_id' => 'required',
            // 'child_category_auto_id' => 'required',
            // 'bname' => 'required',
             'moq' => 'required',
            // 'gross_weight' => 'required',
            // 'net_weight' => 'required',
            'stock' => 'required',
            'product_weight'=>'required',
            'product_discount'  => 'required',

        ],
        [ 
            'ename.required' => 'Please enter name',
            'price.required' => 'Please enter price',
            'edescription.required' => 'Please enter description in english',
            'nstatus.required' => 'Please select new arrival status',
            'main_category_auto_id.required' => 'Please select main category',
            // 'sub_category_auto_id.required' => 'Please select sub category',
            // 'child_category_auto_id.required' => 'Please select child category',
            // 'bname.required' => 'Please select brand',
            'moq.required'=>'please enter maximum order quantity',
            // 'gross_weight.required' => 'please enter gross weight',
            // 'net_weight.required' => 'please enter net weight',
            'product_weight.required' => 'please enter product unit',
            'stock.required' =>'please select stock status',
            'product_discount.required'    => 'Enter product offer percentage', 

        ]);


        if($request->file('pimage')!=''){

              // image***********by vendor
        $name = $request->file('pimage')->getClientOriginalName();
        $request->file('pimage')->move("images/products", $name); 
   
         $sdata = $name; 

        }
          
       
            $maincategory = MainCategory::where('_id','=', $request->get('main_category_auto_id'))->get();
    
            foreach ($maincategory as $main) {
                $main_category_id = $main->main_category_id;
                $main_category_name = $main->main_category_name_english;
                $mcode = $main->code;
            }
       
        
             
        if( $request->input('sub_category_auto_id') != '')
        {
           $subcategory = SubCategory::where('_id','=', $request->input('sub_category_auto_id'))->get();
           foreach($subcategory as $sub)
           {
                $sub_category_id = $sub->sub_category_id;
                $sub_category_name = $sub->name;
                $scode = $sub->code;
           }
        }else{
            $sub_category_id = '';
            $sub_category_name = '';
            $scode = '';
        }
        
        if($request->input('child_category_auto_id') != '')
        {

         $childcategory = ChildCategory::where('_id','=', $request->input('child_category_auto_id'))->get();
           foreach($childcategory as $child)
           {
                $child_category_id = $child->child_category_id;
                $child_category_name = $child->name;
                $ccode = $child->code;
           }
        }else{
            $child_category_id = '';
                $child_category_name ='';
                $ccode ='';
        }
        
         if($request->get('bname') != '')
        {
            $brands = Brands::where('brand_id','=', $request->get('bname'))->get();
    
            foreach ($brands as $brand) {
                $brand_name = $brand->name;
            }
        }else{
            $brand_name = '';
        }
          if(!in_array('Multiprice',$features))
        {
            $units = Unit::where('_id','=', $request->get('product_weight'))->get();
    
            foreach ($units as $ut) {
                $unit_auto_id = $ut->id;
                $product_weight = $ut->unit;
            }
        }else{
             $unit_auto_id = '';
            $product_weight = '';
        }

        $product = Product::find($request->input('pid'));

      
            $product->product_main_category_auto_id = $request->input('main_category_auto_id');
            $product->product_main_category_id = $main_category_id;
             $product->product_main_category_name = $main_category_name;
      
        if($request->input('sub_category_auto_id') != '')
        {
            $product->product_sub_category_auto_id = $request->input('sub_category_auto_id');
            $product->product_sub_category_id = $sub_category_id;
            $product->product_sub_category_name = $sub_category_name;
        }else{
             $product->product_sub_category_auto_id = "";
              $product->product_sub_category_id = "";
            $product->product_sub_category_name = "";
        }
        
       
         if($request->input('child_category_auto_id') != '')
        {
            $product->product_child_category_auto_id = $request->input('child_category_auto_id');
            $product->product_child_category_id = $child_category_id;
            $product->product_child_category_name = $child_category_name;
        }else{
              $product->product_child_category_auto_id = "";
              $product->product_child_category_id ="";
              $product->product_child_category_name = "";
        }
        
        
        if($request->get('bname') != '')
        {
           $product->brand_id = $request->get('bname');
           $product->brand_name = $brand_name;
        }else{
           $product->brand_id ="";
           $product->brand_name = "";
        }
          if(!in_array('Multiprice',$features))
        {
           $product->unit_auto_id = $request->get('product_weight');
           $product->product_weight = $product_weight;
        }else{
           $product->unit_auto_id ="";
           $product->product_weight = "";
        }
        //   if(!in_array('Multiprice',$features))
        // {
        //      $product->product_weight = $request->input('product_weight');
        // }else{
        //     $product->product_weight = "";
        // }
        
        $product->product_name_english = $request->input('ename');
       
        $product->descriptions_english = $request->input('edescription');
        
        if($request->input('nstatus') != '')
        {
            $product->new_arrival_status = $request->input('nstatus');
        }else{
            $product->new_arrival_status = "";
        }
        
        if(in_array('Minimum Order Quantity',$features) && (!in_array('Multiprice',$features)))
        {
             $product->moq = $request->get('moq');
        }else{
             $product->moq = "";
        }
        
        if($request->input('stock') != '')
        {
            $product->stock = $request->get('stock');
        }else{
             $product->stock = "";
        }
        
         if(in_array('Gross Weight',$features) && (!in_array('Multiprice',$features)))
        {
        
           $product->gross_weight = $request->get('gross_weight');
        }else{
            
            if($request->get('gross_weight') == ""){
                $product->gross_weight = "";
            }else{
                 $product->gross_weight = $request->get('gross_weight');
            }
        }
        
        
       if(!in_array('Multiprice',$features))
        {
             $product->qty = $request->get('qty');
        }else{
              $product->qty = "";
        }
        
        if(in_array('Net Weight',$features) && (!in_array('Multiprice',$features)))
        {
            $product->net_weight = $request->get('net_weight');
        }else{
             if($request->get('net_weight') == ""){
                $product->net_weight = "";
            }else{
                 $product->net_weight = $request->get('net_weight');
            }
        }
     
      
        if($request->input('product_status') != '')
        {
            $product->product_status = $request->input('product_status');
        }else{
            $product->product_status = "";
        }
        
        if(!in_array('Multiprice',$features))
        {
            $product->product_price = $request->input('price');
        }else{
            $product->product_price = "";
        }
        
        if(!in_array('Multiprice',$features))
        {
             $product->offer_per = $request->input('product_discount');
        }else{
            $product->offer_per = "";
        }
        
        
        if(!in_array('Multiprice',$features))
        {
			
         $offer_perinprice2 =  ($request->input('price')*($request->input('product_discount')/100));
		 $offer_perinprice = number_format((float)$offer_perinprice2, 2, '.', '');
            
            $product->offer_perinprice  = $offer_perinprice;
        }else{
            $product->offer_perinprice  = "";
        }
        
        
        if(!in_array('Multiprice',$features))
        {
          $final_price2 =$request->input('price') - $offer_perinprice; 
		  
		  $final_price = number_format((float)$final_price2, 2, '.', '');
		  
            $product->final_price  =$final_price;
        }else{
             $product->final_price  ="";
        }
        
        if($request->file('pimage')!=''){
            $product->product_logo =$sdata;
        }
        
        $product->save();
        return redirect('products')->with('success', 'Successfully Updated');

    }



    public function view_gallery($id){
        
           $productimages = ProductImages::where('product_auto_id','=',$id)->get();
    
        $features = $this->getfeatures();

       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
            return view('templates.myadmin.view_product')->with(['allproductimages' => $productimages, 'allfeatures' => $features, 'product_auto_id' => $id]);
        }
    }



    public function delete_gallery($id){
       

    $productimages = ProductImages::where('_id','=',$id)->get();

    if($productimages->isNotEmpty())
    {
      foreach( $productimages as $data1)
      {
          $pid = $data1->product_auto_id;
            // delete image from folder
            $image_path = "images/productimages/$data1->logo"; 
            // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        
      }

        $productimages = ProductImages::find($id);
        $productimages->delete();
       return redirect('view-product/'.$pid)->with('success', 'Deleted Successfully');
     }else{
        return redirect('view-product/'.$pid)->with('success','Something went wrong');
    }

    }



    public function add_product_gallery($id){
       
           $color = ProductColor::get();
    
         $features = $this->getfeatures();

       if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

       }

       else{
        return view('templates.myadmin.add_product_gallery')->with(['productcolor'=> $color,'allfeatures' => $features,'product_auto_id' => $id]);
    }
    }



    public function store_product_gallery(Request $request){

        $this->validate($request, 

        [   

            'pimage' => 'required',
             'color_name' => 'required',

        ],

        [ 

            'pimage.required' => 'Please choose image',
            'color_name.required' => 'Please choose image',

        ]);

         $colors = ProductColor::where('_id','=', $request->get('color_name'))->get();

        foreach ($colors as $clr) {
              $color_auto_id = $clr->id;
              $color = $clr->color;
         }

 
         $name = $request->file('pimage')->getClientOriginalName();
         $request->file('pimage')->move("images/productimages", $name); 
         $data = $name; 
       
        $product = new ProductImages();
        
        $product->product_auto_id = $request->get('product_auto_id');
        $product->logo = $data;
        $product->color_name= $request->input('color_name');
        $product->color_auto_id = $color_auto_id;
        $product->color_name = $color;
        $product->save();

        

        return redirect('view-product/'.$request->get('product_auto_id'))->with('success', 'Added Successfully');

    }

    public function delete($id)
    {
 
       $product = Product::where('_id','=',$id)->get();
        if($product->isNotEmpty())
        {
          foreach( $product as $data)
          {
              
           
           $productimages = ProductImages::where('product_auto_id','=',$data->_id)->get();
            
            if($productimages->isNotEmpty())
            {
                foreach($productimages as $data_a)
                {
                    $image_path_a = "images/productimages/$data->product_logo"; 
                    if(File::exists($image_path_a)) {
                            File::delete($image_path_a);
                    }
                
                }
                 $productimages = ProductImages::where('product_auto_id','=',$data->_id)->delete();
            }

            $product_offers = ProductOffer::where('product_id','=',$data->_id)->get();

            $product_highlight = ProductHighlight::where('product_id','=',$data->_id)->get();
            
            if($productimages->isNotEmpty()){
                
                $product_highlight_delete = ProductHighlight::where('product_id','=',$data->_id)->delete();
            }

            $productmainspecification = ProductMainSpecifications::where('product_auto_id', '=', $data->_id)->get();
            
            if($productmainspecification->isNotEmpty()){
                
                
                
                $productmainspecification_delete = ProductMainSpecifications::where('product_auto_id', '=', $data->_id)->delete();
            }

            $productsize = ProductSize::where('product_auto_id', '=', $data->_id)->get();
            
            if($productsize->isNotEmpty()){
                
            $productsize_delete =  ProductSize::where('product_auto_id', '=', $data->_id)->delete();
            }

            $productRatingReview = ProductRatingReview::where('product_auto_id', '=', $data->_id)->get();
            
            if($productRatingReview->isNotEmpty()){
                
            $productRatingReview_delete =  ProductRatingReview::where('product_auto_id', '=', $data->_id)->delete();
            }
            

            $ProductWeightPricing = ProductWeightPricing::where('product_auto_id', '=', $data->_id)->get();
            
            if($ProductWeightPricing->isNotEmpty()){
                
            $ProductWeightPricing_delete =  ProductWeightPricing::where('product_auto_id', '=', $data->_id)->delete();
            }
            
            
            $image_path_b = "images/products/$data->product_logo"; 
            if(File::exists($image_path_b)) {
                File::delete($image_path_b);
            }
        }
              $product = Product::find($id);
              $product->delete();
      
     
        
       return redirect('products')->with('success', 'Deleted Successfully');
     }else{
        return redirect('products')->with('success','Something went wrong');
    }
    
    }
    
    
    
    public function UpdateEraseDataSatus(Request $request){
        
        $estatus = $request->estatus;
        
        $getautoid = VendorBusinessDetails::where('mcat_id','MCAT37')->Where('erased_data_status','No')->get();
        
        if($getautoid->isNotEmpty()){
            foreach($getautoid as $data){
                $auto_id = $data->id;
            }
            
            $updatedata = VendorBusinessDetails::find($auto_id);
            
            $updatedata->erased_data_status = 'Yes';
            
            $updatedata->save();
            
             return view('templates.myadmin.ajaxdatasub')->with('success', 'Data erased successfully..!!');
            
        }else{
             
              return view('templates.myadmin.ajaxdatasub')->with('error', 'Already erased..!!');
        }
    }
}