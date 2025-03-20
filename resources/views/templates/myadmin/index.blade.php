@if (Session::has('AccessToken'))
   <?php $value = Session::get('AccessToken') ?>
@else
    <script>window.location.href = "MyDashboard";</script>
@endif

@extends('templates.myadmin.layout')

@section('content')

<div class="col-sm-6 col-lg-4" style="margin-bottom: 3%;">

    <a href="{{url('wholesalers')}}"><div class="card text-white bg-flat-color-1" style="background:seagreen;">

        <div class="card-body pb-0">

            <p class="text-light"><i class="fa fa-user"></i> &nbsp;Total Employer</p>

            <h4 class="mb-0">

                <span class="count">{{$wholesaler_count}}</span>

            </h4>

        </div>

    </div></a>

</div>
<div class="col-sm-6 col-lg-4" style="margin-bottom: 3%;">

    <a href="{{url('employee')}}"><div class="card text-white bg-flat-color-1" style="background:teal;">

        <div class="card-body pb-0">

            <p class="text-light"><i class="fa fa-user"></i> &nbsp;Total Employee's</p>

            <h4 class="mb-0">

                <span class="count">{{$employee_count}}</span>

            </h4>

        </div>

    </div></a>

</div>
<div class="col-sm-6 col-lg-4" style="margin-bottom: 3%;">

    <a href="{{url('ecomm-plans')}}"><div class="card text-white bg-flat-color-1" style="background:slateblue;">

        <div class="card-body pb-0">

            <p class="text-light"><i class="fa fa-user"></i> &nbsp;Total Subscription Plans</p>

            <h4 class="mb-0">

                <span class="count">{{$enquiry_count}}</span>

            </h4>

        </div>

    </div></a>

</div>



@endsection