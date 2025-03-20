<?php



namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\MainCategory;
use App\Product;
use App\Uorders;
use App\MarketList;
use DB;
use DateTime;
use DateTimeZone;
use Session;

use App\Traits\Features;

class CategoryController extends Controller

{

    use Features;

    public function add(){

        $features = $this->getfeatures();

       if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

       }

       else{

        return view('templates.myadmin.add-productcategory')->with(['allfeatures'=> $features]);

    }

}

    public function jewellery_index(){


    	$maincategory = MainCategory::get();

        $features = $this->getfeatures();

       if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

       }

       else{

    	return view('templates.myadmin.productcategory')->with(['Category'=>$maincategory,'allfeatures'=> $features]);

    }



}
    public function stock_list_index(){

    $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
 		$order_date = $date->format('Y-m-d');
    	$maincategory = Product::get();
    	
       $uorders = MarketList::where('status', '=', 'Received')->get()->unique('product_auto_id');
       $morders = MarketList::where('status', '=', 'Received')->get();      
   

        $features = $this->getfeatures();

       if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

       }

       else{

    	return view('templates.myadmin.stock_list')->with(['products'=>$maincategory,'allorders'=>$uorders,'morders'=>$morders,'allfeatures'=> $features]);

    }



}

    public function store(Request $request){

    	$this->validate(

          $request, 

            [   

                'ename' => 'required',

                'code' => 'required',

                'status'       => 'required',

                'cimage'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            ],

            [   

                'ename.required' => 'Enter category name in english',

                'code.required' => 'Enter category code',

                'status.required' => 'Select category status.',

                'cimage.required' => 'Choose category image.',

                'cimage.image'   => 'Choose category image.',

                'cimage.mimes'   => 'Category image should be jpeg,png,jpg,gif or svg format only',

            ]

        );

        // get id

        $id = MainCategory::get();

        if($id->isNotEmpty())

        {

            foreach ($id as $data) 

            {

                $mid = $data->main_category_id;

            }

            if($mid != ''){

                $str = explode("MCAT",$mid,3);

                $second = $str[1];

                $naid = $second+1;

                $newaid = "MCAT".$naid;

            }  

            else{

				$newaid = "MCAT101";

            } 

        } 

        else{

            $newaid = "MCAT101";

        }



    	// image

        $name = uniqid().$request->file('cimage')->getClientOriginalName();

       	$request->file('cimage')->move('images/maincategory/', $name);  

       	$data = $name; 


        $maincategory = new MainCategory();


        $maincategory->main_category_id = $newaid;

        $maincategory->main_category_name_english = $request->input('ename');

        $maincategory->logo = $data;

        $maincategory->code = $request->input('code');

        $maincategory->status = $request->input('status');

        $maincategory->save();



         return redirect('main-category')->with('success', 'Added Successfully');

    }



    public function edit($id){

        $maincategory = MainCategory::where('_id','=',$id)->get();

       $features = $this->getfeatures();

       if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

       }

       else{

        return view('templates.myadmin.edit_productcategory')->with(['maincategory'=>$maincategory,'allfeatures'=>$features]);

    }

}



    public function update(Request $request){

        $this->validate(

          $request, 

            [   

                'ename' => 'required',

                'code' => 'required',

                'status'       => 'required',

            ],

            [   

                'ename.required' => 'Enter category name in english',

                'code.required' => 'Enter category code',

                'status.required' => 'Select category status.',

            ]

        );



        if($request->file('cimage')!=''){

            $this->validate(

              $request, 

                [   

                    'cimage'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                ],

                [   

                    'cimage.required' => 'Choose category image.',

                    'cimage.image'   => 'Choose category image.',

                    'cimage.mimes'   => 'Category image should be jpeg,png,jpg,gif or svg format only',

                ]

            );

            // image

            $name = uniqid().$request->file('cimage')->getClientOriginalName();

            $request->file('cimage')->move('images/maincategory/', $name);  

            $data = $name; 

        }



        $maincategory = MainCategory::find($request->get('id'));

        

        $maincategory->main_category_name_english = $request->input('ename');

        if($request->file('cimage')!=''){

            $maincategory->logo = $data;

        }

        $maincategory->code = $request->input('code');

        $maincategory->status = $request->input('status');

        $maincategory->save();



         return redirect('main-category')->with('success', 'Updated Successfully');

    }
//update stock

  public function edit_stock($id){

        $maincategory = Product::where('_id','=',$id)->get();

       $features = $this->getfeatures();

       if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

       }

       else{

        return view('templates.myadmin.edit_available_stock')->with(['main_categories'=>$maincategory,'allfeatures'=>$features]);

    }

}



    public function updates_stock(Request $request){




        $maincategory = Product::find($request->get('id'));

        $maincategory->avl_stock = $request->input('avl_stock');

        $maincategory->save();



         return redirect('stock-list')->with('success', 'Updated Successfully');

    }
}

