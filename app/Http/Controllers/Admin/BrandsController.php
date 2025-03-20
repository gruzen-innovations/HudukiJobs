<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Brands;
use App\MainCategory;
use DB;
use Session;
use File;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;

class BrandsController extends Controller

{

    use Features;
    use VendorPaidOrder;
	public function index()

    {
       
           $brands = Brands::select('*')->ORDERBY('_id','DESC')->get();
       
       
        if(count($brands) == 0){

            $brands = array();

        }

        $features = $this->getfeatures();

        if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

        }

        else{

            return view('templates.myadmin.brands')->with(['brands' => $brands, 'allfeatures'=> $features]);

        }

    }



    public function add(){
        
           $brands = Brands::get();
       
        
           $maincategory = MainCategory::get();
       
        $features = $this->getfeatures();

        if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

        }

        else{

            return view('templates.myadmin.add_brand')->with(['brands' => $brands,'main_categories' => $maincategory, 'allfeatures'=> $features]);

        }

    }



    public function store(Request $request){

		$this->validate($request,[
            'main_category_auto_id' =>'required',

            'brand' => 'required',

            'bimage' => 'required',

            'bimage.*' => 'image|mimes:jpg|max:2048',

        ]); 

    
        
        
         $name = $request->file('bimage')->getClientOriginalName();
         $request->file('bimage')->move("images/brands", $name); 
         $data = $name; 
         $getmaincatname = MainCategory::where('_id',$request->input('main_category_auto_id'))->get();

       foreach($getmaincatname as $MainCategory)
       {
            $maincategory_id = $MainCategory->main_category_id;

            $maincategory_name = $MainCategory->main_category_name_english;
       }

        $brand_count = Brands::get();

	    if(count($brand_count) == 0){

	        $brand_id = 'B1';

	    }

	    else{

	    	$brand_count = Brands::get();

	    	foreach ($brand_count as $demo) {

	    		$getdmid = $demo->brand_id;

	    	}

	    	$str = explode('B',$getdmid,2);

			$second = $str[1];

			$inc_oid = $second+1;

			$brand_id ="B".$inc_oid;

	    }

        $brands = new Brands();
        $brands->main_category_auto_id = $request->input('main_category_auto_id');
       $brands->main_category_id = $maincategory_id;
       $brands->main_category_name_english = $maincategory_name;
        $brands->brand_id = $brand_id;

        $brands->bimage = $data;

        $brands->name = $request->input('brand'); 

        $brands->save();



        $features = $this->getfeatures();

        if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

        }

        else{

            return redirect('brands')->with('success', 'Brand Added Successfully');

        }

    }



    public function showupdatebrand(Request $request)

    {

       

        $this->validate($request,[

            'id' => 'required',

        ]);

        $id = $request->id;
         
           $maincategory = MainCategory::get();
        

        $editquery = Brands::where('brand_id', '=', $id)->get();



        $features = $this->getfeatures();

        if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

        }

        else{

            return view('templates.myadmin.edit_brand',['main_categories'=> $maincategory,'brands'=>$editquery,'allfeatures'=> $features]);

        }

    }



    public function updatebrand(Request $request)

    {

        $id = $request->id;

        $bimage_db = Brands::select('bimage')->where('brand_id', '=', $id)->get();
         $getmaincatname = MainCategory::where('_id',$request->input('main_category_auto_id'))->get();

       foreach($getmaincatname as $MainCategory)
       {
            $maincategory_id = $MainCategory->main_category_id;

            $maincategory_name = $MainCategory->main_category_name_english;
       }



        if((count($bimage_db) == 0) && ($request->file('bimage')=='')){

        	$this->validate($request,[

        		'id' => 'required',

                'main_category_auto_id' =>'required',

            	'brand' => 'required',

            	'bimage' => 'required',

            	'bimage.*' => 'image|mimes:jpg|max:2048',

        	]);

      
        
  
        $name = $request->file('bimage')->getClientOriginalName();
        $request->file('bimage')->move("images/brands", $name); 
        $data = $name; 

        DB::table('brands')->where('brand_id', '=', $id)->update(['name' => $request->input('brand'), 'main_category_auto_id' => $request->input('main_category_auto_id'), 'main_category_id' => $maincategory_id, 'main_category_name_english' => $maincategory_name, 'bimage' => $data]);

        }

        elseif($request->file('bimage')!=''){

        	$this->validate($request,[

        		'id' => 'required',
                'main_category_auto_id' =>'required',

            	'brand' => 'required',

            	'bimage' => 'required',

            	'bimage.*' => 'image|mimes:jpg|max:2048',

        	]);

        
        $name = $request->file('bimage')->getClientOriginalName();
        $request->file('bimage')->move("images/brands", $name); 
         $data = $name; 
       DB::table('brands')->where('brand_id', '=', $id)->update(['name' => $request->input('brand'), 'main_category_auto_id' => $request->input('main_category_auto_id'), 'main_category_id' => $maincategory_id, 'main_category_name_english' => $maincategory_name, 'bimage' => $data]);

        }

        elseif($request->file('bimage')==''){

        	$this->validate($request,[

            	'id' => 'required',
                'main_category_auto_id' =>'required',
            	'brand' => 'required',

        	]);

        	DB::table('brands')->where('brand_id', '=', $id)->update(['main_category_auto_id' => $request->input('main_category_auto_id'), 'main_category_id' => $maincategory_id, 'main_category_name_english' => $maincategory_name, 'name' => $request->input('brand')]);

        }

        

        return redirect('brands')->with('success', 'Updated Successfully');

    }
     public function delete($id)
  {


    $brands = Brands::where('_id','=',$id)->get();

    if($brands->isNotEmpty())
    {
      foreach( $brands as $data1)
      {
            // delete image from folder
            $image_path = "images/brands/$data1->bimage"; 
            // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        
      }

        $brands = Brands::find($id);
        $brands->delete();
       return redirect('brands')->with('success', 'Deleted Successfully');
     }else{
        return redirect('brands')->with('success','Something went wrong');
    }
     
   }

}

