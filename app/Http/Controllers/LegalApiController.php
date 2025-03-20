<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\About;
use App\Terms;
use App\Privacy;
use App\Faq;

class LegalApiController extends Controller
{
    

    public function about_index(){
        $about = About::get();
        if($about->isEmpty()){
            return response()->json([
                'status' => 0, 
                'msg' => config('messages.empty'),
            ]);
        }
        else{
            return response()->json([
                'status' => 1, 
                'allabouts' => $about,
            ]);
        }
    }
    public function terms_index(){
       
       $term = Terms::get();
        if($term->isEmpty()){
            return response()->json([
                'status' => 0, 
                'msg' => config('messages.empty'),
            ]);
        }
        else{
            return response()->json([
                'status' => 1, 
                'allterms' => $term,
            ]);
        }
    }
     public function privacy_index(){
         
        $privacy = Privacy::get();
        if($privacy->isEmpty()){
            return response()->json([
                'status' => 0, 
                'msg' => config('messages.empty'),
            ]);
        }
        else{
            return response()->json([
                'status' => 1, 
                'allprivacy' => $privacy,
            ]);
        }
    }
    public function faq_index(){
            
        $faq = Faq::get();
        if($faq->isEmpty()){
            return response()->json([
                'status' => 0, 
                'msg' => config('messages.empty'),
            ]);
        }
        else{
            return response()->json([
                'status' => 1, 
                'allfaqs' => $faq,
            ]);
        }
    }
}
