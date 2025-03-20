@if (Session::has('AccessToken'))

   <?php $value = Session::get('AccessToken') ?>

@else

    <script>window.location.href = "MyDashboard";</script>

@endif

@extends('templates.myadmin.layout')

@section('content')

@if(!empty($brands))

    @foreach($brands as $brands)

        <?php   

               $name = $brands->name;
                $main_category_auto_id=$brands->main_category_auto_id;
               $bimage = $brands->bimage;

               $bid = $brands->brand_id;

         ?>

    @endforeach

@endif



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

                                <div class="card-header"><strong>Edit Brand Name</strong></div>

                                    <div class="card-body card-block"> 

                                        {!! Form::open(['method' => 'POST', 'url' => 'updatebrand', 'enctype' => 'multipart/form-data']) !!}

                                            <input type="hidden" name="id" value="{{$bid}}">
                                             <div class="form-group col-md-4">
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
                                            <div class="form-group col-md-4">

                                                <label for="vat" class=" form-control-label">Brand</label> 

                                                <input type="text" id="brand" name="brand" placeholder="Brand Name" class="form-control" value="{{$name}}">

                                                <small class="text-danger">{{ $errors->first('brand') }}</small>

                                            </div>

                                            <div class="form-group col-md-4">

                                                <label for="vat" class=" form-control-label">Brand Image(500x500)</label> 

                                                <img src="images/brands/{{$bimage}}" style="max-width: 100px;height: 100px;margin: 10px;" />
                                           
                                        
                                                <img src="../images/brands/{{$bimage}}" style="width:30%"/>
                                        
                                                <input type="file" id="bimage" name="bimage" placeholder="" class="form-control" value="">

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