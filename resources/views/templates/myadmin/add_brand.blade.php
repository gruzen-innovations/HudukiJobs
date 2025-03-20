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
                        <strong class="card-title">Brand</strong>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header"><strong>Add Brand</strong></div>
                                    <div class="card-body card-block"> 
                                        {!! Form::open(['method' => 'POST', 'url' => 'addbrand', 'enctype' => 'multipart/form-data']) !!}
                                         @csrf  
                                            <div class="form-group col-md-4">
                                            <label for="vat" class="form-control-label">Main Category</label> 
                                            <select class="form-control" title="" name="main_category_auto_id" id="main_category_auto_id" >
                                                <option value="">Select Main Category</option>
                                                @if($main_categories->isNotEmpty())
                                                   @foreach($main_categories as $maincategory)
                                                    <option value="{{$maincategory->id}}">{{$maincategory->main_category_name_english}}
                                                  </option>
                                                  @endforeach
                                                   @endif
                                            </select>
                                            <small class="text-danger">{{$errors->first('main_category_auto_id')}}</small>
                                          </div> 
                                            <div class="form-group col-md-4">
                                                <label for="vat" class=" form-control-label">Brand</label> 
                                                <input type="text" id="brand" name="brand" placeholder="Brand Name" class="form-control" value="">
                                                <small class="text-danger">{{ $errors->first('brand') }}</small>
                                            </div>

                                             <div class="form-group col-md-4">
                                                <label for="vat" class=" form-control-label">Brand Image(500x500)</label> 
                                                <input type="file" id="bimage" name="bimage" placeholder="title" class="form-control" value="">
                                                <small class="text-danger">{{ $errors->first('bimage') }}</small>
                                            </div>
                                          
                                            <div class="card-footer col-md-12">  
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fa fa-dot-circle-o"></i> Submit
                                                </button>
                                                <button class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <a href="brands">Cancel</a></button> 
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
    </div><!-- .animated -->
</div><!-- .content -->
@endsection