@if (Session::has('AccessToken'))

   <?php $value = Session::get('AccessToken') ?>

@else

    <script>window.location.href = "MyDashboard";</script>

@endif

@if($profiles->isNotEmpty())

    @foreach($profiles as $profile)

        @php

            $name = $profile->name;

            $username = $profile->username;

            $email = $profile->email;

            $contact = $profile->contact;

        @endphp

    @endforeach
    @else

    @php
        $name = "";
        $username = "";
        $email = ""; 
        $contact = "";
      
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

                        <strong class="card-title">Admin</strong>

                    </div>

                    <div class="card-body">

                        <div class="col-md-12 col-lg-12">

                            <div class="card">

                                <div class="card-header"><strong>My Profile</strong></div>

                                <div class="card-body card-block"> 

                                    <div class="form-group col-md-12">

                                        <label for="vat" class="form-control-label">Name</label> 

                                        <input type="text" id="name" name="name" placeholder="" class="form-control" value="{{$name}}" readonly>

                                        <small class="text-danger">{{ $errors->first('name') }}</small>

                                    </div>



                                    <div class="form-group col-md-12">

                                        <label for="vat" class="form-control-label">UserName</label> 

                                        <input type="text" id="username" name="username" placeholder="" class="form-control" value="{{$username}}" readonly>

                                        <small class="text-danger">{{ $errors->first('username') }}</small>

                                    </div>



                                    <div class="form-group col-md-12">

                                        <label for="vat" class="form-control-label">Contact</label> 

                                        <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$contact}}" readonly>

                                        <small class="text-danger">{{ $errors->first('contact') }}</small>

                                    </div>



                                    <div class="form-group col-md-12">

                                        <label for="vat" class="form-control-label">Email</label> 

                                        <input type="email" id="email" name="email" placeholder="" class="form-control" value="{{$email}}" readonly>

                                        <small class="text-danger">{{ $errors->first('email') }}</small>

                                    </div>

                                    <div class="card-footer col-md-12">  

                                        <button class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <a href="{{url('home')}}">Cancel</a></button> 

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