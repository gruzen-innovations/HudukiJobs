<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductColor;
use Session;
use DB;
use File;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;

class ColorController extends Controller
{
    use Features;
    use VendorPaidOrder;
    public function index(){
      
      $color = ProductColor::get();
    
      $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        // $features = array();
    	return view('templates.myadmin.color')->with(['productcolor'=> $color,'allfeatures' => $features]);
    }
    }
     public function add()
    {
       
       $color = ProductColor::get();
     
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        // $features = array();
        return view('templates.myadmin.add_color')->with(['productcolor' => $color,'allfeatures' => $features]);
    }
  }
    public function store(Request $request){
    	$this->validate(
          $request, 
          [   
            'color' => 'required',
           
        ],
        [   
            'color.required' => 'Enter Product color',
            
        ]
    );
        $color = new ProductColor();
        $color->color= $request->input('color');
        $color->save();
        return redirect('color')->with('success', 'Added Successfully');
    }

    public function delete($id)
  {
    // $maincategory = Maincategory::where('_id','=',$id)->get();

    // if($maincategory->isNotEmpty())
    // {
    //   foreach( $maincategory as $data1)
    //   {

    //      $product = Product::where('product_auto_id','=',$data1->main_category_id)->get();
    //     if($product->isNotEmpty())
    //     {
    //       foreach( $product as $data)
    //       {
    //         $productimages = ProductImages::where('product_auto_id','=',$data->product_auto_id)->delete();

    //         $product_offers = ProductOffer::where('product_id','=',$data->product_auto_id)->get();

    //         $product_highlight = ProductHighlight::where('product_id','=',$data->product_auto_id)->get();

    //         $productmainspecification = ProductMainSpecifications::where('product_auto_id', '=', $data->product_auto_id)->get();

    //         $productsize = ProductSize::where('product_auto_id', '=', $data->product_auto_id)->get();

    //         $productRatingReview = ProductRatingReview::where('product_auto_id', '=', $data->product_auto_id)->get();

    //         $ProductWeightPricing = ProductWeightPricing::where('product_auto_id', '=', $data->product_auto_id)->get();

    //       }

    //       $product = Product::where('product_auto_id','=',$data1->main_category_id)->delete();
    //    }
    //     $delete_subcat = SubCategory::where('main_category_id', '=',$data1->main_category_id)->delete();
    //     $delete_childcat = ChildCategory::Where('main_category_id', '=',$data1->main_category_id)->delete();
    //   }

       
    //      $maincat = MainCategory::find($id);
    //     $maincat->delete();
    //    return redirect('maincategory')->with('success', 'Deleted Successfully');
    //  }

      $color = ProductColor::find($id);
       $color->delete();
      return redirect('color')->with('success', 'Deleted Successfully');
    }


}

