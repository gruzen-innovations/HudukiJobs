<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SubCategory;
use App\MainCategory;
use App\ChildCategory;
use App\Product;
use App\Uorders;
use Session;
use DB;
use File;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;
use App\ProductImages;
use App\ProductOffer;
use App\ProductHighlight;
use App\ProductMainSpecifications;
use App\ProductSize;
use App\ProductRatingReview;
use App\ProductWeightPricing;
class ChildCategoryController extends Controller
{
    use Features;
    use VendorPaidOrder;
    public function index(){
      
      $childcategory = ChildCategory::ORDERBY('_id','DESC')->get();
     
      $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        // $features = array();
    	return view('templates.myadmin.child-category')->with(['child_categories'=> $childcategory,'allfeatures' => $features]);
    }
  }
  public function getSubCategoryByMainCategory(Request $request){
   
    
    $getSubcategory = SubCategory::where('main_category_auto_id',$request->main_category_id)->get();
    
    return view('templates.myadmin.ajaxdatasub')->with(['sub_categories' => $getSubcategory]);
  }
     public function show(){
       
        $category = MainCategory::get();
     
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        
         return view('templates.myadmin.add-child-category')->with(['main_categories'=> $category,'allfeatures' => $features]);
       }
    }


       public function store(Request $request){
      $this->validate(
          $request, 
            [   
            'main_category_auto_id' =>'required',
            'sub_category_auto_id' => 'required',
            'name' => 'required',
            'code' => 'required',
            'cimage'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [   
              'main_category_auto_id.required' => 'Select  main category',
             'sub_category_auto_id.required' => 'Select sub category name',
            'name.required' => 'add child category name',
            'code.required' => 'Enter code',
             'cimage.required' => 'Choose child category image.',
             'cimage.image'   => 'Choose child category image.',
             'cimage.mimes'   => 'child category image should be jpeg,png,jpg,gif or svg format only',
       ]
        );
    
        
         $name = $request->file('cimage')->getClientOriginalName();
         $request->file('cimage')->move("images/childcategory", $name); 
        $data = $name; 


       $getsubcatname = MainCategory::where('_id',$request->input('main_category_auto_id'))->get();

       foreach($getsubcatname as $MainCategory)
       {
            $maincategory_id = $MainCategory->main_category_id;

            $maincategory_name = $MainCategory->main_category_name_english;
       }
      $getsubbcatname = SubCategory::where('_id',$request->input('sub_category_auto_id'))->get();

       foreach($getsubbcatname as $SubCategory)
       {
            $subcategory_id = $SubCategory->sub_category_id;

            $subcategory_name = $SubCategory->name;
       }
       $newaid = uniqid();
       $childcategory = new ChildCategory();
       $childcategory->child_category_id = $newaid;
       $childcategory->main_category_auto_id = $request->input('main_category_auto_id');
       $childcategory->main_category_id = $maincategory_id;
       $childcategory->main_category_name_english = $maincategory_name;
       $childcategory->sub_category_auto_id = $request->input('sub_category_auto_id');
       $childcategory->sub_category_id = $subcategory_id;
       $childcategory->sub_category_name = $subcategory_name;
       $childcategory->image = $data;
       $childcategory->name = $request->input('name');
       $childcategory->code = $request->input('code');
       $childcategory->status = "Active";
       $childcategory->save();
       return redirect('childCategory')->with('success','Added Successfully');
   }
    public function edit($id)
    {
        
       
            $maincategory = MainCategory::select('name','main_category_name_english','id')->get();
      
            $subcategory = SubCategory::select('name','sub_category_name','id')->get();

     $childcategory = ChildCategory::where('_id','=',$id)->get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        // $features = array();
        return view('templates.myadmin.edit-child-category')->with(['child_categories'=> $childcategory,'main_categories'=> $maincategory, 'sub_categories'=> $subcategory, 'allfeatures' => $features]);
    }
}


      public function update(Request $request){
        $this->validate(
          $request, 
            [   
           'main_category_auto_id' =>'required',
            'sub_category_auto_id' => 'required',
            'name' => 'required',
            'code' => 'required',
            ],
            [   
            'main_category_auto_id' => 'Select main category',
             'sub_category_auto_id' => 'Select sub category',
            'code.required' => 'Enter  code',
            'name.required' => 'Add child category name',
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
         'cimg.required' => 'Choose child category image.',
          'cimg.image'   => 'Choose child category image.',
          'cimg.mimes'   => 'child category image should be jpeg,png,jpg,gif or svg format only',
      ]
    );

        $name = $request->file('cimg')->getClientOriginalName();
        $request->file('cimg')->move("images/childcategory", $name); 
        $data = $name; 
   
    }
       $getsubcatname = MainCategory::where('_id',$request->input('main_category_auto_id'))->get();

       foreach($getsubcatname as $MainCategory)
       {
            $maincategory_id = $MainCategory->main_category_id;

            $maincategory_name = $MainCategory->main_category_name_english;
       }
      $getsubbcatname = SubCategory::where('_id',$request->input('sub_category_auto_id'))->get();

       foreach($getsubbcatname as $SubCategory)
       {
            $subcategory_id = $SubCategory->sub_category_id;

            $subcategory_name = $SubCategory->name;
       }

        $childcategory = ChildCategory::find($request->get('id'));
        // $childcategory->main_category_auto_id = $request->input('main_category_auto_id');

         if($request->file('cimg')!='')
          {
            $childcategory->image = $data;
          }

      $childcategory->main_category_auto_id = $request->input('main_category_auto_id');
       $childcategory->main_category_id = $maincategory_id;
       $childcategory->main_category_name = $maincategory_name;
       $childcategory->sub_category_auto_id = $request->input('sub_category_auto_id');
       $childcategory->sub_category_id = $subcategory_id;
       $childcategory->sub_category_name = $subcategory_name;
       $childcategory->name = $request->input('name');
       $childcategory->code = $request->input('code');
       $childcategory->status = $request->input('status');
       $childcategory->save();
        return redirect('childCategory')->with('success','Updated Successfully');
      }
 
    public function delete($id)
    {
 
   $vid = Session::get('AccessToken');
        
    $childcategory = ChildCategory::where('_id','=',$id)->get();

    if($childcategory->isNotEmpty())
    {
      foreach( $childcategory as $data1)
      {
            // delete image from folder
            $image_path = "images/childcategory/$data1->image"; 
            // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        

         $product = Product::where('product_child_category_auto_id','=',$data1->_id)->get();
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

          $product = Product::where('product_child_category_auto_id','=',$data1->_id)->delete();
       }
      }

       $childcat = ChildCategory::find($id);
        $childcat->delete();
       return redirect('childCategory')->with('success', 'Deleted Successfully');
     }else{
        return redirect('childCategory')->with('success','Something went wrong');
    }
}
}




