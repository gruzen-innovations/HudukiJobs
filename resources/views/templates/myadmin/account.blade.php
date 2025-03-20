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

                        <strong class="card-title">Account</strong>

                    </div>

                    <div class="card-body">

                        <div class="col-md-12 col-lg-12">

                            <div class="card">

                            <div class="card-header"><strong>Change Password</strong></div>

                            @include('templates.myadmin.messages')

                            <div class="card-body card-block"> 

                                {!! Form::open(['method' => 'POST', 'url' => 'update-password', 'enctype' => 'multipart/form-data']) !!}

                                    @csrf

                                    <div class="form-group col-md-12">

                                        <label class="form-control-label">Old Password</label> 

                                        <input type="text" id="oldp" name="oldp" placeholder="Old Password" class="form-control" value="">

                                        <small class="text-danger">{{ $errors->first('oldp') }}</small>

                                    </div>

                                    <div class="form-group col-md-12">

                                        <label class="form-control-label">New Password</label> 

                                        <input type="text" id="newp" name="newp" placeholder="New Password" class="form-control" value="">

                                        <small class="text-danger">{{ $errors->first('newp') }}</small>

                                    </div>

                                    <div class="card-footer col-md-12">  

                                         <button type="submit" class="btn btn-success btn-sm">

                                            <i class="fa fa-dot-circle-o"></i> Submit

                                        </button>      

                                        <button class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <a href="home">Cancel</a></button> 

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

@endsection