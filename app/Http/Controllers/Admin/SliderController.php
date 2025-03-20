<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Slider;
use App\SubCategory;
use App\MainCategory;
use Session;
use File;
use App\Traits\VendorPaidOrder;

class SliderController extends Controller
{
   
public function index()
   {
   
           $slider = Slider::get();
 
        
     return view('templates.myadmin.slider')->with(['sliders' => $slider]);
   
  }
    public function show(){
       
      $category = MainCategory::get();
        $slider = Slider::get();
      
        
        return view('templates.myadmin.add_slider')->with(['sliders'=>$slider,'main_categories'=>$category]);
        
    }

    public function store(Request $request)
  {
     $this->validate(
         $request,
           [  
            'main_category_auto_id' =>'required',
            'sub_category_auto_id' => 'required',
             'sname' =>'required',
             'cimage'   => 'required',
           ],
           [  
                'main_category_auto_id.required' => 'Select  main category',
             'sub_category_auto_id.required' => 'Select sub category name',
             'sname.required' =>'add slider name',
             'cimage.required' => 'Choose slider image.',
             'cimage.image'   => 'Choose slider image.',
             'cimage.mimes'   => 'slider image should be jpeg,png,jpg,gif or svg format only',
      ]
       );


        $name = $request->file('cimage')->getClientOriginalName();
        $request->file('cimage')->move("images/slider", $name);  
        $data = $name; 
         $getsubcatname = MainCategory::where('_id',$request->input('main_category_auto_id'))->get();

       foreach($getsubcatname as $MainCategory)
       {

            $maincategory_name = $MainCategory->main_category_name_english;
       }
      $getsubbcatname = SubCategory::where('_id',$request->input('sub_category_auto_id'))->get();

       foreach($getsubbcatname as $SubCategory)
       {

            $subcategory_name = $SubCategory->name;
       }
     $slider = new  Slider();
       $slider->main_category_auto_id = $request->input('main_category_auto_id');
       $slider->main_category_name_english = $maincategory_name;
       $slider->sub_category_auto_id = $request->input('sub_category_auto_id');
       $slider->sub_category_name = $subcategory_name;

     $slider->image = $data;
     $slider->sname = $request->input('sname');
     $slider->save();

     return redirect('slider')->with('success', 'Added Successfully');
     }




 public function edit($id)
   {
      
            $maincategory = MainCategory::get();
      
            $subcategory = SubCategory::get();
    
           $slider = Slider::where('_id',$id)->get();
     
        return view('templates.myadmin.edit_slider')->with(['sliders' => $slider,'main_categories'=> $maincategory, 'sub_categories'=> $subcategory]);
    
    
   }

   public function update(Request $request)
     {
       if($request->file('cimg')!='')
       {
         $this->validate(
          $request, 
            [   'main_category_auto_id' =>'required',
            'sub_category_auto_id' => 'required',
                'sname' => 'required',
            ],
            [   'main_category_auto_id' => 'Select main category',
             'sub_category_auto_id' => 'Select sub category',
                'sname.required' => 'Add slider name',
            ]
        );
         $this->validate(
           $request,
           [  
             'cimg'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           ],
           [  
             'cimg.required' => 'Choose slider image.',
             'cimg.image'   => 'Choose slider image.',
             'cimg.mimes'   => 'slider image should be jpeg,png,jpg,gif or svg format only',
           ]
         );
                
       
      
       
        $name = $request->file('cimg')->getClientOriginalName();
        $request->file('cimg')->move("images/slider", $name);  
         $data = $name;
       }
         $getsubcatname = MainCategory::where('_id',$request->input('main_category_auto_id'))->get();

       foreach($getsubcatname as $MainCategory)
       {

            $maincategory_name = $MainCategory->main_category_name_english;
       }
      $getsubbcatname = SubCategory::where('_id',$request->input('sub_category_auto_id'))->get();

       foreach($getsubbcatname as $SubCategory)
       {

            $subcategory_name = $SubCategory->name;
       }

         $Slider = Slider::find($request->get('id'));
         $Slider->sname = $request->input('sname');
         $Slider->main_category_auto_id = $request->input('main_category_auto_id');
       $Slider->main_category_name = $maincategory_name;
       $Slider->sub_category_auto_id = $request->input('sub_category_auto_id');
       $Slider->sub_category_name = $subcategory_name;
           if($request->file('cimg')!='')
              {
                  $Slider->image = $data;
              }
       
        $Slider->save();
       return redirect('slider')->with('success','Updated Successfully');
     }
public function delete($id)
  {
    
        $slider = Slider::find($id);
        $slider->delete();
       return redirect('slider')->with('success', 'Deleted Successfully');
     
   }
  }      