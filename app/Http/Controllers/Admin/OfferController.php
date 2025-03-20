<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Offers;
use App\Country;
use Session;
use DB;
use File;
use App\Traits\Features;
use App\Traits\VendorPaidOrder;

class OfferController extends Controller

{
     use Features;
     use VendorPaidOrder;
    public function index(){
       $offer = Offers::get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
    	return view('templates.myadmin.offers')->with(['offers'=>$offer,'allfeatures' => $features]);
        }
    }



    public function add(){
        
       $countries = Country::get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }else{
        return view('templates.myadmin.add_offer')->with(['countries'=>$countries, 'allfeatures' => $features]);
       }
    }

    public function store(Request $request){
    	$this->validate(
        $request, 
            [   
                'cimage'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [   
                'cimage.required' => 'Choose image.',
                'cimage.image'   => 'Choose image.',
                'cimage.mimes'   => 'Image should be jpeg,png,jpg,gif or svg format only',
            ]
        );

       
         $name = $request->file('cimage')->getClientOriginalName();
         $request->file('cimage')->move("images/offers", $name); 
         $data = $name; 
    
         $countries = Country::where('country_code','=',$request->input('country_code'))->get();
        if($countries->isNotEmpty()){
            foreach ($countries as $country) {
               $country_name = $country->country_name;
            }
        }else{
            $country_name = "";
        }
        $offer = new Offers();
        $offer->country_code = $request->input('country_code');
        $offer->country_name = $country_name;
        $offer->logo = $data;
        $offer->save();

         return redirect('offers')->with('success', 'Added Successfully');

    }



    public function edit($id){

    
        $countries = Country::get();
        $offer = Offers::where('_id','=',$id)->get();
        $features = $this->getfeatures();
           if(empty($features)){
               return redirect('MyDashboard')->with( 'error', "Something went wrong");
           }else{
               return view('templates.myadmin.edit_offer')->with(['offers' => $offer, 'countries' => $countries, 'allfeatures' => $features]);
          }
    }

    public function update(Request $request){
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

        $name = $request->file('cimage')->getClientOriginalName();
        $request->file('cimage')->move("images/offers", $name); 
        $data = $name; 

            $countries = Country::where('country_code','=',$request->input('country_code'))->get();
            if($countries->isNotEmpty()){
                foreach ($countries as $country) {
                   $country_name = $country->country_name;
                }
            }else{
                $country_name = "";
            }

            $offer = Offers::find($request->get('id'));
            $offer->logo = $data;
            $offer->country_code = $request->input('country_code');
            $offer->country_name = $country_name;
            $offer->save();

        }

        return redirect('offers')->with('success', 'Updated Successfully');
    }

    public function delete($id){
    $offers = Offers::where('_id','=',$id)->get();
    if($offers->isNotEmpty())
    {
      foreach( $offers as $data1)
      {
            // delete image from folder
            $image_path = "images/offers/$data1->logo"; 
            // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        
      }

        $offer = Offers::find($id);
        $offer->delete();
        
       return redirect('offers')->with('success', 'Deleted Successfully');
     }else{
        return redirect('offers')->with('success','Something went wrong');
    }


    }

}