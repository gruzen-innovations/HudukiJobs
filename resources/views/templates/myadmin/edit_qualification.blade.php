@if (Session::has('AccessToken'))
   <?php $value = Session::get('AccessToken') ?>
@else
    <script>window.location.href = "MyDashboard";</script>
@endif

@extends('templates.myadmin.layout')
@section('content')

@if(!empty($qualifications))

    @foreach($qualifications as $promocode)

        @php

            $id = $promocode->id;

            $name = $promocode->name;

         

        @endphp

    @endforeach

@endif



<div class="content mt-3">

    <div class="animated fadeIn">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header">

                        <strong class="card-title">Qualifications</strong>

                    </div>

                    <div class="card-body">

                        <div class="col-md-12 col-lg-12">

                            <div class="card">

                                <div class="card-header"><strong>Edit Qualification</strong></div>

                                <div class="card-body card-block"> 

                                    {!! Form::open(['method' => 'POST', 'url' => 'update-qualification', 'enctype' => 'multipart/form-data']) !!}
                                    @csrf 
                                    <input type="hidden" name="id" value="{{$id}}">
                                      
                                        

                                        <div class="form-group col-md-6">

                                            <label for="company" class=" form-control-label">Name</label>

                                            <input type="text" id="name" placeholder="Enter name" class="form-control" name="name" value="{{$name}}">

                                            <small class="text-danger">{{ $errors->first('name') }}</small>

                                        </div>

                                        <div class="card-footer col-md-12">  

                                            <button type="submit" class="btn btn-success btn-sm">

                                                <i class="fa fa-dot-circle-o"></i> Submit

                                            </button>

                                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> 

                                                <a href="{{url('qualification')}}"> Cancel</a>

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