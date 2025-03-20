<!-- @if (Session::has('Access-Token'))
   <?php $value = Session::get('Access-Token') ?>
@else
    <script>window.location.href = "MyDashboard";</script>
@endif -->
@extends('templates.myadmin.layout')
@section('content')
@if(!empty($sliders))
    @foreach($sliders as $slider)
        @php
          $id = $slider->id;
          $sname = $slider->sname;
          $slider = $slider->image;
          $main_category_auto_id = $slider->main_category_auto_id;
          $sub_category_auto_id = $slider->sub_category_auto_id;
          $sub_category_name = $slider->sub_category_name;
        @endphp
    @endforeach
@endif
<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title"> Slider</strong>
                    </div>
                     <div class="card-body">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header"><strong>Edit Slider</strong></div>
                                <div class="card-body card-block"> 
                                    {!! Form::open(['method' => 'POST', 'url' => 'update-slider', 'enctype' => 'multipart/form-data']) !!}
                                        @csrf 
                                    
                                        <input type="hidden" name="id" value="{{$id}}"> 
                                        <div class="form-group col-md-6">
                                            <label for="vat" class="form-control-label">Main Category</label> 
                                            <select class="form-control" title="" name="main_category_auto_id" id="main_category_auto_id" >
                                            <option value="">Select</option>
                                            @if($main_categories->isNotEmpty())
                                            @foreach($main_categories as $maincategory)

                                             <option value="{{$maincategory->id}}" @if($maincategory->id == $main_category_auto_id) selected @endif>{{$maincategory->main_category_name_english}}
                                            </option>

                                            @endforeach
                                            @endif
                                            </select>
                                            <small class="text-danger">{{ $errors->first('main_category_auto_id') }}</small>
                                        </div> 
                                        <div class="form-group col-md-6">
                                            <label for="vat" class=" form-control-label">Sub Category</label> 
                                            <select name="sub_category_auto_id" id="sub_category_auto_id" class="form-control">
                                            <option value="{{$sub_category_auto_id}}" >{{$sub_category_name}}
                                            </option>
                                            <option value="">Select subcategory</option>
                                             </select>
                                            <small class="text-danger">{{ $errors->first('sub_category_auto_id') }}</small>
                                        </div>     
                                         <div class="form-group col-md-6">
                                            <label for="vat" class="form-control-label">Name</label><br/>
                                           
                                            <input type="text" id="" name="sname" class="form-control" value="{{$sname}}" >
                                            <small class="text-danger">{{ $errors->first('sname') }}</small>
                                        </div>                
                                        <div class="form-group col-md-6">
                                            <label for="vat" class="form-control-label">Image</label><br/>
                                            <img src="../images/slider/{{$slider}}" style="width:30%"/>
                                        
                                            <input type="file" id="" name="cimg" class="form-control" value="" >
                                            <small class="text-danger">{{ $errors->first('cimg') }}</small>
                                        </div>
                                      
                                        <div class="card-footer col-md-12">  
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa fa-dot-circle-o"></i> Submit
                                            </button>
                                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> 
                                                <a href="{{url('slider')}}"> Cancel</a>
                                            </button> 
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<script>
// get subject

        $("#main_category_auto_id").change(function(){
          
             var token = "{{ csrf_token() }}";

            var id = ($('#main_category_auto_id option:selected').val());
            
                $.ajax({

                  url: "<?php echo route('getSubCategoryBySubCategory'); ?>",

                  method: 'POST',

                  data: {  '_token': token,

                            'main_category_id':id},

                 dataType: "html",

                  success: function(data) {
                  
                     $("#sub_category_auto_id").html(data);

                  }

              });
        });
</script>
@endsection