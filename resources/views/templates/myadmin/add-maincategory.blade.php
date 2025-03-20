@if (Session::has('AccessToken'))
   <?php $value = Session::get('AccessToken') ?>
@else
    <script>window.location.href = "MyDashboard";</script>
@endif
@extends('templates.myadmin.layout')
@section('content')
<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title"> Main Category</strong>
                    </div>
                     <div class="card-body">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header"><strong>Add Main Category</strong></div>
                                    <div class="card-body card-block"> 
                                        {!! Form::open(['method' => 'POST', 'url' => 'add-main-category', 'enctype' => 'multipart/form-data']) !!}
                                            @csrf  
                                         
                                             <div class="form-group col-md-6">
                                                <label for="vat" class="form-control-label">Name</label> 
                                                <input type="text" id="name" name="name"  class="form-control" value="">
                                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                            </div>
                                       
                                            <div class="form-group col-md-6">
                                                <label for="vat" class="form-control-label">Code</label> 
                                                <input type="text" id="code" name="code"  class="form-control" value="">
                                                <small class="text-danger">{{ $errors->first('code') }}</small>
                                            </div>
                                             <div class="form-group col-md-6">
                                            <label class="form-control-label">Image(80x80)</label> 
                                            <input type="file" name="cimage" class="form-control" value="" >
                                            <small class="text-danger">{{ $errors->first('cimage') }}</small>
                                            </div> 
                                             <div class="col-md-6 form-group">
                                             <label for="company" class=" form-control-label">Sort(Set Priority)</label>
                                               <input type="number" id="sort_number" placeholder="Enter number" class="form-control" name="sort_number" value="{{old('sort_number')}}" min="1" max="100">
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
                                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <a href="{{url('add-maincategory')}}">Cancel</a></button> 
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
</div>                                      
@endsection