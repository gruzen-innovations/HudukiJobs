<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SubCategory;
use App\MainCategory;
use App\Product;
use App\ChildCategory;
use App\Uorders;
use Session;
use File;
use DB;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;
use App\ProductImages;
use App\ProductOffer;
use App\ProductHighlight;
use App\ProductMainSpecifications;
use App\ProductSize;
use App\ProductRatingReview;
use App\ProductWeightPricing;
class SubCategoryController extends Controller
{
    use Features;
    use VendorPaidOrder;
    
    public function index(){
    
      $subcategory = SubCategory::ORDERBY('_id','DESC')->get();
     
      $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        // $features = array();
    	return view('templates.myadmin.subcategory')->with(['sub_categories'=> $subcategory,'allfeatures' => $features]);
    }
  }

    public function show_add()
    {
    
      $maincategory = MainCategory::get();
      
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
           else{
            // $features = array();
            return view('templates.myadmin.add-subcategory')->with(['main_categories' => $maincategory,'allfeatures' => $features]);
        }
   }
 
       public function store(Request $request){
       
      $this->validate(
          $request, 
            [   
            'main_category_auto_id' =>'required',
            'name' => 'required',
            'code' => 'required',
            'cimage'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [   
              'main_category_auto_id.required' => 'Select  main category',
              'name.required' => 'add sub category name',
             'code.required' => 'Enter code',
             'cimage.required' => 'Choose sub category image.',
             'cimage.image'   => 'Choose sub category image.',
             'cimage.mimes'   => 'sub category image should be jpeg,png,jpg,gif or svg format only',
       ]
        );
 
       
         $name = $request->file('cimage')->getClientOriginalName();
         $request->file('cimage')->move("images/subcategory", $name); 
          $data = $name; 

       $getsubcatname = MainCategory::where('_id',$request->input('main_category_auto_id'))->get();

       foreach($getsubcatname as $MainCategory)
       {
            $maincategory_id = $MainCategory->main_category_id;

            $maincategory_name = $MainCategory->main_category_name_english;
       }
        $newaid = uniqid();
       $SubCategory = new SubCategory();
       $SubCategory->sub_category_id = $newaid;
       $SubCategory->main_category_auto_id = $request->input('main_category_auto_id');
       $SubCategory->main_category_id = $maincategory_id;
       $SubCategory->main_category_name_english = $maincategory_name;
       $SubCategory->image = $data;
       $SubCategory->name = $request->input('name');
       $SubCategory->code = $request->input('code');
       $SubCategory->status = "Active";
       $SubCategory->save();
       return redirect('subcategory')->with('success','Added Successfully');
   }
 
    public function edit($id)
    {   
    
       $maincategory = MainCategory::get();
        
        $subcategory = SubCategory::where('_id','=',$id)->get();
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        // $features = array();
    return view('templates.myadmin.edit_sub_category')->with(['main_categories'=> $maincategory,'sub_categories' => $subcategory,'allfeatures' => $features]);
    }
}
 
  public function update(Request $request){
        $this->validate(
          $request, 
            [   
            'main_category_auto_id' =>'required',
            'code' => 'required',
            'name' => 'required',
            'status' => 'required',
            ],
            [   
            'main_category_auto_id' => 'Select main category',
            'code.required' => 'Enter  code',
            'name.required' => 'Add sub category name',
            'status.required' => 'Select status',
            ]
        );
        


        if($request->file('cimg')!=''){
        $this->validate(
          $request, 
          [   
            'cimg'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          ],
          [   
             'cimg.required' => 'Choose sub category image.',
              'cimg.image'   => 'Choose sub category image.',
              'cimg.mimes'   => 'sub category image should be jpeg,png,jpg,gif or svg format only',
          ]
        );


        $name = $request->file('cimg')->getClientOriginalName();
        $request->file('cimg')->move("images/subcategory", $name); 
        $data = $name; 
    }
        $getsubcatname = MainCategory::where('_id',$request->input('main_category_auto_id'))->get();

       foreach($getsubcatname as $MainCategory)
       {
            $maincategory_id = $MainCategory->main_category_id;

            $maincategory_name = $MainCategory->main_category_name_english;
       }


        $subcategory = SubCategory::find($request->get('id'));
        $subcategory->main_category_auto_id = $request->input('main_category_auto_id');

         if($request->file('cimg')!='')
          {
            $subcategory->image = $data;
          }

       $subcategory->main_category_id =$request->input('main_category_auto_id');
       $subcategory->main_category_name_english = $maincategory_name;
       $subcategory->name = $request->input('name');
       $subcategory->code = $request->input('code');
       $subcategory->status = $request->input('status');
       $subcategory->save();
        return redirect('subcategory')->with('success','Updated Successfully');
      }

 
   public function delete($id)
   {
        $vid = Session::get('AccessToken');
        
    $subcategory = Subcategory::where('_id','=',$id)->get();

    if($subcategory->isNotEmpty())
    {
      foreach( $subcategory as $data1)
      {
            // delete image from folder
            $image_path = "images/subcategory/$data1->image"; 
            // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        

         $product = Product::where('product_sub_category_auto_id','=',$data1->_id)->get();
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

          $product = Product::where('product_sub_category_auto_id','=',$data1->_id)->delete();
       }
        $delete_childcat = ChildCategory::Where('sub_category_auto_id', '=',$data1->_id)->delete();
      }

       
         $subcat = SubCategory::find($id);
        $subcat->delete();
       return redirect('subcategory')->with('success', 'Deleted Successfully');
     }else{
        return redirect('subcategory')->with('success','Something went wrong');
    }
    }
}




