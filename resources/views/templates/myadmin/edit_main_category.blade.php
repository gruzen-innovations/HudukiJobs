@if (Session::has('AccessToken'))
<?php $value = Session::get('AccessToken') ?>
@else
<script>window.location.href = "MyDashboard";</script>
@endif
@extends('templates.myadmin.layout')
@section('content')
@if(!empty($main_categories))
    @foreach($main_categories as $maincategory)
        @php
            $id = $maincategory->id;
            $code = $maincategory->code;
            $name = $maincategory->main_category_name_english;
            $status = $maincategory->status;
            $image = $maincategory->image;
            $sort_number = $maincategory->sort_number;
        @endphp
    @endforeach
@endif
<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title"> Edit Main Category</strong>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header"><strong>Edit Main Category</strong></div>
                                <div class="card-body card-block"> 
                                    {!! Form::open(['method' => 'POST', 'url' => 'update-main-category', 'enctype' => 'multipart/form-data']) !!}
                                    @csrf 
                                    <input type="hidden" name="id" value="{{$id}}">                        
                                    
                                  <div class="form-group col-md-6">
                                            <label for="vat" class="form-control-label">Name</label><br/>
                                           
                                            <input type="text" id="" name="name" class="form-control" value="{{$name}}" >
                                            <small class="text-danger">{{ $errors->first('name') }}</small>
                                        </div>  

                                    <div class="form-group col-md-6">
                                        <label for="vat" class="form-control-label">Code</label> 
                                        <input type="text" id="code" name="code"  class="form-control" value="{{$code}}">
                                        <small class="text-danger">{{ $errors->first('code') }}</small>
                                    </div>
                                    
                                     <div class="form-group col-md-6">
                                        <label for="vat" class="form-control-label">Status</label> 
                                        <select class="form-control" title="" name="status" id="status" >
                                            <option value="" selected disabled >Select</option>
                                           <option value="Active" @if($status == "Active") selected @endif>Active</option>
                                               <option value="Inactive" @if($status == "Inactive") selected @endif>Inactive</option>
                                           </select>
                                        <small class="text-danger">{{ $errors->first('status') }}</small>
                                    </div> 
                                     <div class="form-group col-md-6">
                                        <label for="vat" class="form-control-label">Image(80x80)</label><br/>
                                         <img src="../images/maincategory/{{$image}}" style="width:30%"/>
                                        
                                            <input type="file" id="" name="cimg" class="form-control" value="" >
                                            <small class="text-danger">{{ $errors->first('cimg') }}</small>
                                    </div>
                                    <div class="col-md-6 form-group">
                                     <label for="company" class=" form-control-label">Sort(Set Priority)</label>
                                      <input type="number" id="sort_number" placeholder="Enter number" class="form-control" name="sort_number" value="{{$sort_number}}" min="1" max="100">
                                      <small class="text-danger">
                                        @if($errors->first('sort_number') != '')
                                          {{ $errors->first('sort_number') }} 
                                           @endif
                                    </small>
                                    </div>
                                    <div class="card-footer col-md-12">  
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <a href="{{url('maincategory')}}">Cancel</a></button>
                                    </div>
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
@endsection