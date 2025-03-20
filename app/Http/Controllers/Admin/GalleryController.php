<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gallery;
use Session;
use File;

use App\Traits\Features;
use App\Traits\VendorPaidOrder;
class GalleryController extends Controller
{
    use Features;  
    use VendorPaidOrder; 
    public function index()
   {

        $gallery = Gallery::get();
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }else{
        return view('templates.myadmin.gallery')->with(['galleries'=>$gallery,'allfeatures' => $features]);
       }
  }
    public function show(){
        
        $gallery = Gallery::get();
        $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        return view('templates.myadmin.add_gallery')->with(['galleries'=>$gallery, 'allfeatures' => $features]);
         }
       
    }

    public function store(Request $request)
  {
     $this->validate(
         $request,
           [  
             'gname' =>'required',
            'cimage'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           ],
           [  
             'gname.required' =>'add gallery name',
             'cimage.required' => 'Choose gallery image.',
             'cimage.image'   => 'Choose gallery image.',
             'cimage.mimes'   => 'gallery image should be jpeg,png,jpg,gif or svg format only',
      ]
       );

     $name = $request->file('cimage')->getClientOriginalName();
     $request->file('cimage')->move("images/gallery", $name);  
     $data = $name; 
     
     $gallery = new  Gallery();
     $gallery->image = $data;
     $gallery->gname = $request->input('gname');
     $gallery->save();

     return redirect('gallery')->with('success', 'Added Successfully');
     }




 public function edit($id)
   {
       $gallery = Gallery::where('_id','=',$id)->get();
       $features = $this->getfeatures();
       if(empty($features)){
           return redirect('MyDashboard')->with( 'error', "Something went wrong");
       }
       else{
        return view('templates.myadmin.edit_gallery')->with(['galleries' => $gallery, 'allfeatures' => $features]);
     }
    
   }

   public function update(Request $request)
     {
       if($request->file('cimg')!='')
       {
         $this->validate(
          $request, 
            [   
                'gname' => 'required',
               
            ],
            [   
                'gname.required' => 'Add gallery name',
               
            ]
        );
         $this->validate(
           $request,
           [  
             'cimg'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           ],
           [  
             'cimg.required' => 'Choose gallery image.',
             'cimg.image'   => 'Choose gallery image.',
             'cimg.mimes'   => 'gallery image should be jpeg,png,jpg,gif or svg format only',
           ]
         );
         
        
        $name = $request->file('cimg')->getClientOriginalName();
        $request->file('cimg')->move("images/gallery", $name);  
        $data = $name;
       }
         
         $Gallery = Gallery::find($request->get('id'));
         $Gallery->gname = $request->input('gname');
         if($request->file('cimg')!=''){
                  $Gallery->image = $data;
         }
         $Gallery->save();
       return redirect('gallery')->with('success','Updated Successfully');
     }
public function delete($id)
  {

    $gallery = Gallery::where('_id','=',$id)->get();
    if($gallery->isNotEmpty())
    {
      foreach( $gallery as $data1){
            // delete image from folder
            $image_path = "images/gallery/$data1->image"; 
            // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        
      }

        $gallery = Gallery::find($id);
        $gallery->delete();
       return redirect('gallery')->with('success', 'Deleted Successfully');
     }else{
        return redirect('gallery')->with('success','Something went wrong');
    }
      
   }
  }      