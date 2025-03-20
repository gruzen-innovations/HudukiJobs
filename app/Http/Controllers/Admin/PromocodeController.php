<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Promocode;
use DB;
use Session;
use File;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;

class PromocodeController extends Controller

{
     use Features;
     use VendorPaidOrder;
    public function index(){
    
           $promocode = Promocode::get();
    
         $features = $this->getfeatures();

        if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

        }

        else{
        return view('templates.myadmin.promocode')->with(['promocodes' => $promocode,'allfeatures'=> $features]);
    }
    }



    public function add(){
    
           $promocode = Promocode::get();
    
         $features = $this->getfeatures();

        if(empty($features)){

           return redirect('MyDashboard')->with( 'error', "Something went wrong");

        }

        else{
        return view('templates.myadmin.add_promocode')->with(['promocodes' => $promocode, 'allfeatures'=> $features]);
    }
    }



    public function store(Request $request){

        $this->validate(

          $request, 

            [   


               'from_customers' => 'required',

                'to_customers' => 'required',

                'code' => 'required',

                'discount' => 'required',

                'money_up_to' => 'required',

                'description' => 'required',


            ],

            [   

           
                'from_customers.required' => 'Enter from date',

                'to_customers.required' => 'Enter to date',

                'code.required' => 'Enter code',

                'discount.required' => 'Enter discount',

                'money_up_to.required' => 'Enter money up to',

                'description.required' => 'Enter description',
            ]

        );


      
        $promocode = new Promocode();

        $promocode->code = $request->input('code');

        $promocode->discount = $request->input('discount');

        $promocode->money_up_to = $request->input('money_up_to');

        $promocode->description = $request->input('description');

        $promocode->from_customers = $request->input('from_customers');

        $promocode->to_customers = $request->input('to_customers');

		$promocode->save();

       

        return redirect('promocode')->with('success', 'Added Successfully');

    }

 public function edit($id)
    {
        $promocode = Promocode::where('_id','=',$id)->get();
        
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
       
        return view('templates.myadmin.edit_promocode')->with(['promocodes'=> $promocode, 'allfeatures' => $features]);
    }
}


    public function update(Request $request){

       $this->validate(

          $request, 

            [   

                
                'from_customers' => 'required',

                'to_customers' => 'required',

                'code' => 'required',

                'discount' => 'required',

                'money_up_to' => 'required',

                'description' => 'required',


            ],

            [   

                'from_customers.required' => 'Enter from date',

                'to_customers.required' => 'Enter to date',

                'code.required' => 'Enter code',

                'discount.required' => 'Enter discount',

                'money_up_to.required' => 'Enter money up to',

                'description.required' => 'Enter description',

            ]

        );

      
      
       

        $promocode = Promocode::find($request->get('id'));

      	$promocode->code = $request->input('code');

        $promocode->discount = $request->input('discount');

        $promocode->money_up_to = $request->input('money_up_to');

        $promocode->description = $request->input('description');

        $promocode->from_customers = $request->input('from_customers');

        $promocode->to_customers = $request->input('to_customers');

        $promocode->save();



        return redirect('promocode')->with('success', 'Updated Successfully');

    }



      

public function delete($id)

{

      $promocode = Promocode::find($id);

      $promocode->delete();

      return redirect('promocode')->with('success', 'Deleted Successfully');

    }

}



