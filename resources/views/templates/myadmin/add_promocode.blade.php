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

                        <strong class="card-title"> Promocode</strong>

                    </div>

                     <div class="card-body">

                        <div class="col-md-12 col-lg-12">

                            <div class="card">

                                <div class="card-header"><strong>Add Promocode</strong></div>

                                <div class="card-body card-block"> 

                                    {!! Form::open(['method' => 'POST', 'url' => 'store-promocode', 'enctype' => 'multipart/form-data']) !!}

                                        @csrf  

                                        <div class="form-group col-md-6">

                                            <label for="company" class=" form-control-label">From Date</label>

                                            <input type="date" id="from_customers" placeholder="From Date" class="form-control" name="from_customers">

                                            <small class="text-danger">{{ $errors->first('from_customers') }}</small>

                                        </div>
                                         <div class="form-group col-md-6">

                                            <label for="company" class=" form-control-label">To Date</label>

                                            <input type="date" id="to_customers" placeholder="To Date" class="form-control" name="to_customers">

                                            <small class="text-danger">{{ $errors->first('to_customers') }}</small>

                                        </div>


                                        <div class="form-group col-md-6">

                                            <label for="company" class=" form-control-label">Code</label>

                                            <input type="text" id="code" placeholder="Enter code" class="form-control" name="code">

                                            <small class="text-danger">{{ $errors->first('code') }}</small>

                                        </div>



                                        <div class="form-group col-md-6">

                                            <label for="Price" class=" form-control-label">Discount(%)</label>

                                            <input type="number" id="discount" placeholder="Enter discount" class="form-control" name="discount">

                                            <small class="text-danger">{{ $errors->first('discount') }}</small>

                                        </div>

                                       

                                        <div class="form-group col-md-6">

                                            <label for="Color" class=" form-control-label">Money(Upto)</label>

                                            <input type="text" id="money_up_to" placeholder="Enter upto money" class="form-control" name="money_up_to">

                                            <small class="text-danger">{{ $errors->first('money_up_to') }}</small>

                                        </div>



                                        <div class="form-group col-md-6">

                                            <label for="Color" class=" form-control-label">Descriptions</label>

                                            <textarea id="description" placeholder="Enter description" class="form-control" name="description" cols="10"></textarea>

                                            <small class="text-danger">{{ $errors->first('description') }}</small>

                                        </div>

                                        

                                        <div class="card-footer col-md-12">  

                                            <button type="submit" class="btn btn-success btn-sm">

                                                <i class="fa fa-dot-circle-o"></i> Submit

                                            </button>

                                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <a href="{{url('promocode')}}">Cancel</a></button> 

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