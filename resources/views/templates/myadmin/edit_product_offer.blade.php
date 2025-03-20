@if (Session::has('AccessToken'))
   <?php $value = Session::get('AccessToken') ?>
@else
    <script>window.location.href = "MyDashboard";</script>
@endif
@extends('templates.myadmin.layout')
@section('content')
@if(!empty($pofer))
    @foreach($pofer as $pofer)
        <?php   
               $offer = $pofer->product_offer;
               $id = $pofer->id;
         ?>
    @endforeach
@endif

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Product</strong>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header"><strong>Edit Product Offer</strong></div>
                                    <div class="card-body card-block"> 
                                        @if (Session::has('message'))
                                            <div class="alert alert-warning">{{ Session::get('message') }}</div>
                                        @endif
                                        @if (Session::has('success'))
                                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                                        @endif
                                        
                                        {!! Form::open(['method' => 'POST', 'url' => 'updateproductoffer', 'enctype' => 'multipart/form-data']) !!}
                                            <input type="hidden" name="id" value="{{$id}}">
                                            <div class="form-group">
                                                <label for="vat" class=" form-control-label">Offer</label> 
                                                <input type="text" id="offer" name="offer" placeholder="" class="form-control" value="{{$offer}}">
                                                <small class="text-danger">{{ $errors->first('offer') }}</small>
                                            </div>
                                          
                                            <div class="card-footer">  
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fa fa-dot-circle-o"></i> Submit
                                                </button>
                                                <button class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <a href="{{url('products')}}">Cancel</a></button> 
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