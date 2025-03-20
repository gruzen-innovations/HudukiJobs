@if (Session::has('AccessToken'))
<?php $value = Session::get('AccessToken') ?>
@else
<script>window.location.href = "MyDashboard";</script>
@endif

@extends('templates.myadmin.layout')

@section('content')

@if(!empty($promocodes))

    @foreach($promocodes as $promocode)

        @php

            $id = $promocode->id;

            $code = $promocode->code;

            $discount = $promocode->discount;

            $from_customers = $promocode->from_customers;

            $to_customers = $promocode->to_customers;

            $money_up_to = $promocode->money_up_to;

            $description = $promocode->description;

        @endphp

    @endforeach

@endif



<div class="content mt-3">

    <div class="animated fadeIn">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header">

                        <strong class="card-title">Promocode</strong>

                    </div>

                    <div class="card-body">

                        <div class="col-md-12 col-lg-12">

                            <div class="card">

                                <div class="card-header"><strong>Edit Promocode</strong></div>

                                <div class="card-body card-block"> 

                                    {!! Form::open(['method' => 'POST', 'url' => 'update-promocode', 'enctype' => 'multipart/form-data']) !!}
                                    @csrf 
                                    <input type="hidden" name="id" value="{{$id}}">
                                        <div class="form-group col-md-6">

                                            <label for="company" class=" form-control-label">From Date</label>

                                            <input type="text" id="from_customers" placeholder="Enter From date" class="form-control" name="from_customers" value="{{$from_customers}}">

                                            <small class="text-danger">{{ $errors->first('from_customers') }}</small>

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="company" class=" form-control-label">To Date</label>

                                            <input type="text" id="to_customers" placeholder="Enter to date" class="form-control" name="to_customers" value="{{$to_customers}}">

                                            <small class="text-danger">{{ $errors->first('to_customers') }}</small>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="company" class=" form-control-label">Code</label>

                                            <input type="text" id="code" placeholder="Enter code" class="form-control" name="code" value="{{$code}}">

                                            <small class="text-danger">{{ $errors->first('code') }}</small>

                                        </div>



                                        <div class="form-group col-md-6">

                                            <label for="Price" class=" form-control-label">Discount(%)</label>

                                            <input type="number" id="discount" placeholder="Enter discount" class="form-control" name="discount" value="{{$discount}}">

                                            <small class="text-danger">{{ $errors->first('discount') }}</small>

                                        </div>

                                       

                                        <div class="form-group col-md-6">

                                            <label for="Color" class=" form-control-label">Money(Upto)</label>

                                            <input type="text" id="money_up_to" placeholder="Enter upto money" class="form-control" name="money_up_to" value="{{$money_up_to}}">

                                            <small class="text-danger">{{ $errors->first('money_up_to') }}</small>

                                        </div>

                                         <div class="form-group col-md-6">

                                            <label for="Color" class=" form-control-label">Descriptions</label>

                                            <textarea id="description" placeholder="Enter description" class="form-control" name="description" cols="10">{{$description}}</textarea>

                                            <small class="text-danger">{{ $errors->first('description') }}</small>

                                        </div>





                                        <div class="card-footer col-md-12">  

                                            <button type="submit" class="btn btn-success btn-sm">

                                                <i class="fa fa-dot-circle-o"></i> Submit

                                            </button>

                                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> 

                                                <a href="{{url('promocode')}}"> Cancel</a>

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

@endsection