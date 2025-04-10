@if (Session::has('AccessToken'))
   <?php $value = Session::get('AccessToken') ?>
@else
    <script>window.location.href = "MyDashboard";</script>
@endif

@extends('templates.myadmin.layout')
@section('content')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>



<div class="content mt-3">

    <div class="animated fadeIn">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header">

                        <strong class="card-title">Advance Skills</strong>

                    </div>

                     <div class="card-body">

                        <div class="col-md-12 col-lg-12">

                            <div class="card">

                                <div class="card-header"><strong>Add Skills</strong></div>

                                <div class="card-body card-block"> 

                                    {!! Form::open(['method' => 'POST', 'url' => 'store-advance-skills', 'enctype' => 'multipart/form-data']) !!}

                                        @csrf  

                                      


                                        <div class="form-group col-md-12">

                                            <label for="company" class=" form-control-label">Name(Comma Seperated)</label>

                                            <input type="text" id="name" placeholder="Enter name" class="form-control" name="name">

                                            <small class="text-danger">{{ $errors->first('name') }}</small>

                                        </div>



                                        <div class="card-footer col-md-12">  

                                            <button type="submit" class="btn btn-success btn-sm">

                                                <i class="fa fa-dot-circle-o"></i> Submit

                                            </button>

                                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <a href="{{url('advance-skills')}}">Cancel</a></button> 

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