@if (Session::has('AccessToken'))
   <?php $value = Session::get('AccessToken') ?>
@else
    <script>window.location.href = "MyDashboard";</script>
@endif

@if($allcharges->isNotEmpty())

    @foreach($allcharges as $charge)

        @php 
              $ord_amount = $charge->min_order_amount;
              $refer_amount = $charge->refer_amount;
              $id = $charge->id; 
              $tax = $charge->tax;
              
        @endphp

    @endforeach

@else

    @php
        $ord_amount = 0;
        $refer_amount = 0;
        $id = 0; 
        $tax = 0;
     @endphp

@endif

@extends('templates.myadmin.layout')

@section('content')

<div class="content mt-3">

    <div class="animated fadeIn">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header">

                        <strong class="card-title">Charges</strong>

                    </div>

                    <div class="card-body">

                        <div class="col-md-12 col-lg-12">

                            <div class="card">

                                <div class="card-header"><strong>Update Charges</strong></div>

                                <div class="card-body card-block"> 

                                    @include('templates.myadmin.messages')

                                    {!! Form::open(['method' => 'POST', 'url' => 'update-charges', 'enctype' => 'multipart/form-data']) !!}

                                        @csrf

                                        <input type="hidden" name="id" value="{{$id}}">

                                        <div class="form-group col-md-4">

                                            <label for="vat" class="form-control-label">Applicable Charges Amount</label> 

                                            <input type="number" id="ord_amount" name="ord_amount" placeholder="" class="form-control" value="{{$ord_amount}}" >

                                            <small class="text-danger">{{ $errors->first('ord_amount') }}</small>

                                        </div>

                                            

                                        <div class="form-group col-md-4">

                                            <label for="vat" class="form-control-label">Refer & Earn Amount</label> 

                                            <input type="number" id="refer_amount" name="refer_amount" placeholder="" class="form-control" value="{{$refer_amount}}" >

                                            <small class="text-danger">{{ $errors->first('refer_amount') }}</small>

                                        </div>

                                        <div class="form-group col-md-4">

                                               <label for="vat" class="form-control-label">Tax(%)</label>
    
                                               <input type="number" id="tax" name="tax" placeholder="" class="form-control" value="{{$tax}}" >
    
                                               <small class="text-danger">{{ $errors->first('tax') }}</small>

                                       </div>
                                       
                                       <div class="card-footer col-md-12">  

                                            <button type="submit" class="btn btn-success btn-sm">

                                                <i class="fa fa-dot-circle-o"></i> Submit

                                            </button>

                                                        

                                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <a href="{{url('home')}}">Cancel</a></button> 

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