<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductRatingReview;
use DB;
use Session;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;

class ProductRatingReviewController extends Controller
{
 	   use Features;  
     use VendorPaidOrder;
    public function index($id){
   
    
        $rating = ProductRatingReview::where('product_auto_id','=',$id)->get();
    
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
    	return view('templates.myadmin.product_rating_review')->with(['product_rating_review' => $rating, 'allfeatures' => $features,  'product_auto_id'=>$id]);
   }
}
 
  public function delete($id){
        $ratings = ProductRatingReview::where('_id',$id)->get();
        foreach ($ratings as $value) 
        {
         $pid = $value->product_auto_id;
        }
        $rating = ProductRatingReview::find($id);
        $rating->delete();
        return redirect('product-review-rating/'.$pid)->with('success', 'Deleted Successfully');
    }   
}
