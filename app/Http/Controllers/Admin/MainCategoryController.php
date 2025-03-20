<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MainCategory;
use App\Uorders;
use App\Product;
use App\SubCategory;
use App\ChildCategory;
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
class MainCategoryController extends Controller
{
    use Features;
    use VendorPaidOrder;
    public function index(){
      
      $maincategory = MainCategory::ORDERBY('sort_number','ASC')->get();
      $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
    	return view('templates.myadmin.maincategory')->with(['main_categories'=> $maincategory,'allfeatures' => $features]);
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
        return view('templates.myadmin.add-maincategory')->with(['main_categories' => $maincategory,'allfeatures' => $features]);
    }
  }
    public function store(Request $request){
    	$this->validate(
          $request, 
          [   
            'name' => 'required',
            'code' => 'required',
            'cimage'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_number'=>'required',
        ],
        [   
            'name.required' => 'add main category name',
            'code.required' => 'Enter code',
            'sort_number' =>'Enter number',
             'cimage.required' => 'Choose main category image.',
             'cimage.image'   => 'Choose main category image.',
             'cimage.mimes'   => 'main category image should be jpeg,png,jpg,gif or svg format only',
        ]
    );
       
       
         $name = $request->file('cimage')->getClientOriginalName();
         $request->file('cimage')->move("images/maincategory", $name); 
         $data = $name; 
        $newaid = uniqid();
        $maincategory = new MainCategory();
        $maincategory->main_category_id = $newaid;
        $maincategory->main_category_name_english= $request->get('name');
        $maincategory->code = $request->input('code');
        $maincategory->sort_number = (int)$request->input('sort_number');
        $maincategory->image = $data;
        $maincategory->status = "Active";
        $maincategory->save();
        return redirect('maincategory')->with('success', 'Added Successfully');
    }

    public function edit($id)
    {
       $maincategory = MainCategory::where('_id','=',$id)->get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
           return view('templates.myadmin.edit_main_category')->with(['main_categories'=> $maincategory,'allfeatures' => $features]);
        }
    }

    public function update(Request $request){
          $this->validate(
          $request, 
          [   
            
            'code' => 'required',
            'name' => 'required',
            'status' => 'required',
            'sort_number'=>'required',
        ],
        [   
           
            'code.required' => 'Enter category code',
            'name.required' => 'Select category type',
            'status.required' => 'Select category status.',
            'sort_number.required' => 'Enter number.',
        ]
    );
     if($request->file('cimg')!='')
       {
         $this->validate(
           $request,
           [  
             'cimg'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           ],
           [  
             'cimg.required' => 'Choose main category image.',
             'cimg.image'   => 'Choose main category image.',
             'cimg.mimes'   => 'main category image should be jpeg,png,jpg,gif or svg format only',
           ]
         );
       
        $name = $request->file('cimg')->getClientOriginalName();
        $request->file('cimg')->move("images/maincategory", $name); 
        $data = $name; 
       }
       
        $auto_id = $request->get('id');
        $maincategory = MainCategory::find($auto_id);
        $maincategory->code = $request->input('code');
        $maincategory->main_category_name_english = $request->input('name');
        $maincategory->sort_number = (int)$request->input('sort_number');
        $maincategory->status = $request->input('status');
        if($request->file('cimg')!=''){
            $maincategory->image = $data;
        }
        $maincategory->save();
        
        return redirect('maincategory')->with('success','Updated Successfully');
    }
   



 public function delete($id)
  {
   
    $vid = Session::get('AccessToken');
    $maincategory = Maincategory::where('_id','=',$id)->get();
    // if($maincategory->isNotEmpty())
    // {
      foreach( $maincategory as $data1)
      {
            // delete image from folder
            $image_path = "images/maincategory/$data1->image"; 
            // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        

         $product = Product::where('product_main_category_auto_id','=',$data1->_id)->get();
        if($product->isNotEmpty())
        {
          foreach( $product as $data)
          {
            $productimages = ProductImages::where('product_auto_id','=',$data->_id)->get();
            if($productimages->isNotEmpty()){
                foreach($productimages as $data_a){
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

          $product = Product::where('product_main_category_auto_id','=',$data1->_id)->delete();
       }
        $delete_subcat = SubCategory::where('main_category_auto_id', '=',$data1->_id)->delete();
        
        $delete_childcat = ChildCategory::Where('main_category_auto_id', '=',$data1->_id)->delete();
      }

        $maincat = Maincategory::find($id);
        $maincat->delete();
        
       return redirect('maincategory')->with('success', 'Deleted Successfully');
   }


}

