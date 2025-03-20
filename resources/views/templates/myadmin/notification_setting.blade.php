@if (Session::has('AccessToken'))
   <?php $value = Session::get('AccessToken') ?>
@else
    <script>window.location.href = "MyDashboard";</script>
@endif

@if($notification_settings->isNotEmpty())

    @foreach($notification_settings as $settings)

        @php $package_name = $settings->package_name;

        $key = $settings->key;

        $id = $settings->id; 
        @endphp

    @endforeach

@else
    @php $package_name = "";
        $key = "";
        $id = 0; 
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

                        <strong class="card-title">Notification Settings</strong>

                    </div>

                    <div class="card-body">

                        <div class="col-md-12 col-lg-12">

                            <div class="card">

                                <div class="card-header"><strong>Update Notification Settings</strong></div>

                                <div class="card-body card-block"> 

                                    @include('templates.myadmin.messages')

                                    {!! Form::open(['method' => 'POST', 'url' => 'update-notification-setting', 'enctype' => 'multipart/form-data']) !!}

                                        @csrf

                                        <input type="hidden" name="id" value="{{$id}}">

                                        <div class="form-group col-md-6">

                                            <label for="vat" class="form-control-label">package name</label> 

                                            <input type="text" id="package_name" name="package_name" placeholder="" class="form-control" value="{{$package_name}}" >

                                            <small class="text-danger">{{ $errors->first('package_name') }}</small>

                                        </div>

                                            

                                        <div class="form-group col-md-6">

                                            <label for="vat" class="form-control-label">Key</label> 

                                            <input type="text" id="key" name="key" placeholder="" class="form-control" value="{{$key}}" >

                                            <small class="text-danger">{{ $errors->first('key') }}</small>

                                        </div>

                                    


                                        <div class="card-footer col-md-12">  

                                            <button type="submit" class="btn btn-success btn-sm">

                                                <i class="fa fa-dot-circle-o"></i> Submit

                                            </button>

                                                        

                                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <a href="{{url('notification-setting')}}">Cancel</a></button> 

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