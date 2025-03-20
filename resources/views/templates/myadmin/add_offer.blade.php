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
                        <strong class="card-title">Offer</strong>
                    </div>
                     <div class="card-body">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header"><strong>Add Offer</strong></div>
                                <div class="card-body card-block"> 
                                    {!! Form::open(['method' => 'POST', 'url' => 'store-offer', 'enctype' => 'multipart/form-data']) !!}
                                        @csrf  
                                        <div class="form-group col-md-6">
                                            <label for="vat" class="form-control-label">Image(320x160)</label> 
                                            <input type="file" id="cimage" name="cimage" class="form-control" value="" >
                                            <small class="text-danger">{{ $errors->first('cimage') }}</small>
                                        </div> 
                                        
                                        <div class="card-footer col-md-12">  
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa fa-dot-circle-o"></i> Submit
                                            </button>
                                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <a href="{{url('offers')}}">Cancel</a></button> 
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
@endsection